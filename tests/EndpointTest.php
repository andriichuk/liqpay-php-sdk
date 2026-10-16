<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests;

use Andriichuk\LiqPay\LiqPay;
use Andriichuk\LiqPay\Request\AbstractRequest;
use Andriichuk\LiqPay\Tests\Support\FakeHttpClient;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class EndpointTest extends TestCase
{
    public static function endpoints(): iterable
    {
        $cases = json_decode(file_get_contents(__DIR__.'/Fixtures/endpoints.json'), true, 512, JSON_THROW_ON_ERROR);
        foreach ($cases as $case) {
            yield $case['class'] => [$case];
        }
    }

    #[DataProvider('endpoints')]
    public function test_every_endpoint_produces_the_documented_request_and_native_response(array $case): void
    {
        $response = ['result' => 'ok', 'payment_id' => 42, 'amount' => '19.90', 'wait_amount' => false, 'nested' => ['enabled' => true, 'missing' => null], 'list' => [1, '2', 3.5]];
        $http = new FakeHttpClient(new Response(200, ['Content-Type' => 'application/json'], json_encode($response, JSON_THROW_ON_ERROR)));
        $client = new LiqPay('public-key', 'private-key', httpClient: $http);
        $builder = self::build($client, $case['factory']);
        self::assertSame('Andriichuk\\LiqPay\\Request\\'.$case['class'], $builder::class);
        foreach ($case['parameters'] as $field => $value) {
            $method = self::setter($field);
            $builder = $builder->$method($value);
        }
        $result = $builder->send();
        if ($case['endpoint'] === 'checkout') {
            self::assertSame([], $http->requests);
            self::assertSame($case['url'], $result['url']);
            $envelope = $result;
        } else {
            self::assertSame($response, $result);
            self::assertCount(1, $http->requests);
            $request = $http->requests[0];
            self::assertSame($case['url'], (string) $request->getUri());
            self::assertSame('application/json', $request->getHeaderLine('Accept'));
            if (str_starts_with($case['endpoint'], 'public')) {
                self::assertSame('GET', $request->getMethod());
                self::assertSame('', (string) $request->getBody());
                self::assertStringNotContainsString('private-key', (string) $request->getUri());
                self::assertStringNotContainsString('public-key', (string) $request->getUri());

                return;
            }
            self::assertSame('POST', $request->getMethod());
            if ($case['endpoint'] === 'request') {
                self::assertSame('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
                parse_str((string) $request->getBody(), $envelope);
            } else {
                self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
                $envelope = json_decode((string) $request->getBody(), true, 512, JSON_THROW_ON_ERROR);
            }
        }
        $payload = json_decode(base64_decode($envelope['data'], true), true, 512, JSON_THROW_ON_ERROR);
        $expected = ['action' => $case['action'], ...$case['defaults'], ...$case['parameters']];
        if ($case['endpoint'] === 'request' || $case['endpoint'] === 'checkout') {
            $expected['version'] = 7;
            $expected['public_key'] = 'public-key';
        }
        self::assertEquals($expected, $payload);
        foreach ($expected as $key => $value) {
            self::assertSame($value, $payload[$key], 'Native payload type for '.$key);
        }
        self::assertArrayNotHasKey('private_key', $payload);
        self::assertSame(base64_encode(hash('sha3-256', 'private-key'.$envelope['data'].'private-key', true)), $envelope['signature']);
    }

    public static function missingFields(): iterable
    {
        foreach (self::endpoints() as $name => [$case]) {
            foreach ($case['required'] as $field) {
                yield $name.' missing '.$field => [$case, $field];
            }
        }
    }

    #[DataProvider('missingFields')]
    public function test_required_fields_fail_before_any_http_call(array $case, string $missing): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{}'));
        $builder = self::build(new LiqPay('public', 'private', httpClient: $http), $case['factory']);
        $parameters = $case['parameters'];
        unset($parameters[$missing]);
        try {
            $builder->withParameters($parameters)->send();
            self::fail('A required parameter was accepted without '.$missing);
        } catch (\InvalidArgumentException $e) {
            self::assertStringContainsString($missing, $e->getMessage());
            self::assertSame([], $http->requests);
        }
    }

    public static function fundingVariants(): iterable
    {
        $variants = [
            'HoldRequest' => [['card' => '4242424242424242'], ['apay_token' => 'apple'], ['gpay_token' => 'google']],
            'DccRequest' => [['card' => '4242424242424242'], ['card_token' => 'token']],
            'TransferToAccountRequest' => [['card' => '4242424242424242'], ['card_token' => 'token']],
            'TransferToCardRequest' => [['receiver_card' => '4242424242424242'], ['receiver_card_token' => 'token'], ['receiver_account' => 'UA123', 'receiver_mfo' => '305299', 'receiver_okpo' => '12345678', 'receiver_company' => 'Company']],
            'TokenCreateRequest' => [['pushAccountReceipt' => 'receipt'], ['pushdata' => 'device', 'customer' => 'customer'], ['card' => '4242424242424242', 'card_cvv' => '123', 'card_exp_month' => '12', 'card_exp_year' => '29']],
            'TokenCreateUniqueRequest' => [['pushAccountReceipt' => 'receipt'], ['pushdata' => 'device', 'customer' => 'customer'], ['card' => '4242424242424242', 'card_cvv' => '123', 'card_exp_month' => '12', 'card_exp_year' => '29']],
            'ApplePayRequest' => [['applepay_token' => 'apple'], ['card' => '4242424242424242', 'tavv' => 'cryptogram', 'card_exp_month' => '12', 'card_exp_year' => '29']],
            'GooglePayRequest' => [['gpay_token' => 'google'], ['card' => '4242424242424242', 'tavv' => 'cryptogram', 'card_exp_month' => '12', 'card_exp_year' => '29']],
        ];
        foreach (self::endpoints() as $name => [$case]) {
            if (! isset($variants[$name])) {
                continue;
            }
            $fundingFields = array_unique(array_merge(...array_map('array_keys', $variants[$name])));
            foreach ($fundingFields as $field) {
                unset($case['parameters'][$field]);
            }
            foreach ($variants[$name] as $i => $variant) {
                yield $name.' variant '.$i => [$case, $variant];
            }
        }
    }

    #[DataProvider('fundingVariants')]
    public function test_alternative_funding_methods(array $case, array $funding): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{"result":"ok"}'));
        $builder = self::build(new LiqPay('public', 'secret', httpClient: $http), $case['factory'])->withParameters($case['parameters']);
        foreach ($funding as $field => $value) {
            $method = self::setter($field);
            $builder = $builder->$method($value);
        }
        self::assertSame(['result' => 'ok'], $builder->send());
        self::assertCount(1, $http->requests);
    }

    #[DataProvider('fundingVariants')]
    public function test_missing_funding_fails_before_sending(array $case, array $funding): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{}'));
        $builder = self::build(new LiqPay('public', 'secret', httpClient: $http), $case['factory'])->withParameters($case['parameters']);
        try {
            $builder->send();
            self::fail('Expected funding validation');
        } catch (\InvalidArgumentException $e) {
            self::assertStringContainsString('requires one complete parameter group', $e->getMessage());
            self::assertSame([], $http->requests);
        }
    }

    public function test_all_concrete_request_classes_have_endpoint_tests(): void
    {
        $classes = [];
        foreach (self::endpoints() as [$case]) {
            $classes[] = $case['class'];
        }
        $files = array_map(static fn (string $file): string => basename($file, '.php'), glob(__DIR__.'/../src/Request/*Request.php'));
        $files = array_values(array_filter($files, static fn (string $name): bool => ! str_starts_with($name, 'Abstract')));
        sort($files);
        sort($classes);
        self::assertSame($files, $classes);
    }

    private static function build(LiqPay $client, array $path): AbstractRequest
    {
        $builder = $client;
        foreach ($path as $method) {
            $builder = $builder->$method();
        }
        self::assertInstanceOf(AbstractRequest::class, $builder);

        return $builder;
    }

    private static function setter(string $field): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $field))));
    }
}
