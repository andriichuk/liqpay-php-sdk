<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Configuration;
use Andriichuk\LiqPay\LiqPay;
use Andriichuk\LiqPay\Tests\Support\FakeHttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FluentRequestTest extends TestCase
{
    private function client(?FakeHttpClient $http = null): LiqPay
    {
        return new LiqPay('public', 'secret', httpClient: $http ?? new FakeHttpClient(new Response(200, [], '{"result":"ok"}')));
    }

    public function test_refund_example_and_legacy_signature(): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{"result":"ok","wait_amount":"true","payment_id":"2417662437","status":"reversed"}'));
        $result = $this->client($http)->refund()->orderId('order_id_1')->version('3')->send();
        self::assertSame(['result' => 'ok', 'wait_amount' => 'true', 'payment_id' => '2417662437', 'status' => 'reversed'], $result);
        parse_str((string) $http->requests[0]->getBody(), $envelope);
        self::assertSame(['action' => 'refund', 'version' => 3, 'order_id' => 'order_id_1', 'public_key' => 'public'], json_decode(base64_decode($envelope['data']), true));
        self::assertSame(base64_encode(sha1('secret'.$envelope['data'].'secret', true)), $envelope['signature']);
    }

    public function test_current_refund_requires_amount(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('API v7 refunds require amount');
        $this->client()->refund()->orderId('order')->send();
    }

    public function test_builders_branch_without_leaking_state(): void
    {
        $template = $this->client()->refund()->amount('10.00');
        $first = $template->orderId('first')->version(3);
        $second = $template->orderId('second');
        self::assertArrayNotHasKey('order_id', $template->toArray());
        self::assertSame('first', $first->toArray()['order_id']);
        self::assertSame('second', $second->toArray()['order_id']);
        self::assertSame(7, $second->toArray()['version']);
        self::assertSame(['action' => 'refund', 'version' => 7], $this->client()->refund()->toArray());
    }

    public function test_optional_version_can_be_set_before_other_fields(): void
    {
        self::assertSame(['result' => 'ok'], $this->client()->refund()->version(ApiVersion::V3)->orderId('order')->send());
    }

    public function test_nested_splits_and_fiscal_data(): void
    {
        $split = [['public_key' => 'other', 'amount' => '2.50', 'commission_payer' => 'sender']];
        $rro = ['items' => [['id' => 1, 'amount' => 2, 'price' => 1.25, 'cost' => 2.50]], 'delivery_emails' => ['test@example.com']];
        $payload = $this->client()->checkout()->amount('2.50')->currency('UAH')->description('Книга')->orderId('rro')->splitRules($split)->rroInfo($rro)->payload();
        $decoded = json_decode(base64_decode($payload['data']), true);
        self::assertSame(json_encode($split, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $decoded['split_rules']);
        self::assertSame($rro, $decoded['rro_info']);
        self::assertSame('2.50', $decoded['amount']);
    }

    public function test_checkout_form_escapes_text_and_supports_subscription(): void
    {
        $checkout = $this->client()->checkout()->action('subscribe')->amount(25)->currency('UAH')->description('Monthly')->orderId('subscription')->subscribeDateStart('2026-11-01 00:00:00')->subscribePeriodicity('month');
        self::assertStringContainsString('&lt;Pay &amp; go&gt;', $checkout->form('<Pay & go>'));
        self::assertStringNotContainsString('<Pay & go>', $checkout->form('<Pay & go>'));
        self::assertSame('subscribe', json_decode(base64_decode($checkout->payload()['data']), true)['action']);
    }

    public static function reserved(): iterable
    {
        foreach (['action', 'version', 'public_key', 'private_key', 'data', 'signature', ''] as $name) {
            yield [$name];
        }
    }

    #[DataProvider('reserved')]
    public function test_reserved_fields_cannot_be_overridden(string $name): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client()->refund()->withParameter($name, 'override');
    }

    public static function invalidAmounts(): iterable
    {
        foreach ([0, -1, '0', '-1.00', 'bad', '', NAN, INF] as $amount) {
            yield [$amount];
        }
    }

    #[DataProvider('invalidAmounts')]
    public function test_invalid_amounts_are_rejected(int|float|string $amount): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client()->refund()->orderId('order')->amount($amount)->send();
    }

    public function test_order_id_length_is_checked(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client()->refund()->orderId(str_repeat('a', 256))->amount(1)->send();
    }

    public function test_custom_fields_retain_native_types(): void
    {
        $http = new FakeHttpClient(new Response(200, [], '[]'));
        $this->client($http)->refund()->orderId('new-fields')->amount(2)->withParameter('future_option', ['flag' => false, 'count' => 0])->send();
        parse_str((string) $http->requests[0]->getBody(), $envelope);
        self::assertSame(['flag' => false, 'count' => 0], json_decode(base64_decode($envelope['data']), true)['future_option']);
    }

    public function test_configurable_guzzle_transport_and_default_facade(): void
    {
        $history = [];
        $optionsSeen = [];
        $mock = new MockHandler([new Response(200, [], '{"result":"ok"}')]);
        $stack = HandlerStack::create(static function ($request, $options) use ($mock, &$optionsSeen) {
            $optionsSeen = $options;

            return $mock($request, $options);
        });
        $stack->push(Middleware::history($history));
        $config = new Configuration(apiBaseUri: 'https://payments.example.test/api/', httpOptions: ['handler' => $stack, 'timeout' => 4.5, 'connect_timeout' => 1.2, 'proxy' => 'http://localhost:8080'], userAgent: 'my-application');
        $client = new LiqPay('public', 'secret', configuration: $config);
        self::assertSame(['result' => 'ok'], $client->refund()->orderId('order')->amount(1)->send());
        self::assertSame('https://payments.example.test/api/request', (string) $history[0]['request']->getUri());
        self::assertSame('my-application', $history[0]['request']->getHeaderLine('User-Agent'));
        self::assertSame(4.5, $optionsSeen['timeout']);
        self::assertSame(1.2, $optionsSeen['connect_timeout']);
        self::assertSame('http://localhost:8080', $optionsSeen['proxy']);
        self::assertFalse($optionsSeen['allow_redirects']);
        self::assertFalse($optionsSeen['http_errors']);
    }

    public function test_default_version_can_be_configured(): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{}'));
        $client = new LiqPay('public', 'secret', httpClient: $http, configuration: new Configuration(apiVersion: ApiVersion::V3));
        $client->subscriptions()->cancel()->orderId('existing')->send();
        parse_str((string) $http->requests[0]->getBody(), $envelope);
        self::assertSame(3, json_decode(base64_decode($envelope['data']), true)['version']);
        self::assertSame('unsubscribe', json_decode(base64_decode($envelope['data']), true)['action']);
    }
}
