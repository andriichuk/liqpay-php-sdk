<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests;

use Andriichuk\LiqPay\Exception\HttpException;
use Andriichuk\LiqPay\Exception\InvalidResponseException;
use Andriichuk\LiqPay\Exception\TransportException;
use Andriichuk\LiqPay\LiqPay;
use Andriichuk\LiqPay\Tests\Support\FakeHttpClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class TransportTest extends TestCase
{
    public static function nativeResponses(): iterable
    {
        yield 'object' => ['{"amount":"1.00","count":2,"enabled":true,"empty":null}', ['amount' => '1.00', 'count' => 2, 'enabled' => true, 'empty' => null]];
        yield 'list' => ['[{"id":1},false,"true"]', [['id' => 1], false, 'true']];
        yield 'string' => ['"raw value"', 'raw value'];
        yield 'boolean' => ['false', false];
        yield 'integer' => ['42', 42];
        yield 'float' => ['1.25', 1.25];
        yield 'null' => ['null', null];
        yield 'bigint' => ['{"id":9223372036854775808}', ['id' => '9223372036854775808']];
        yield 'business error' => ['{"result":"error","err_code":"invalid_order_id","err_description":"Unknown order"}', ['result' => 'error', 'err_code' => 'invalid_order_id', 'err_description' => 'Unknown order']];
    }

    #[DataProvider('nativeResponses')]
    public function test_original_json_types_and_business_errors(string $body, mixed $expected): void
    {
        $http = new FakeHttpClient(new Response(200, [], $body));
        self::assertSame($expected, (new LiqPay('public', 'secret', httpClient: $http))->status()->orderId('order')->send());
    }

    public static function invalidResponses(): iterable
    {
        yield [''];
        yield ['{invalid'];
        yield ['<html>Proxy error</html>'];
    }

    #[DataProvider('invalidResponses')]
    public function test_malformed_json_is_not_silently_converted_to_null(string $body): void
    {
        $this->expectException(InvalidResponseException::class);
        $http = new FakeHttpClient(new Response(200, [], $body));
        (new LiqPay('public', 'secret', httpClient: $http))->status()->orderId('order')->send();
    }

    public static function statusCodes(): iterable
    {
        foreach ([301, 400, 401, 403, 404, 422, 429, 500, 503] as $code) {
            yield [$code];
        }
    }

    #[DataProvider('statusCodes')]
    public function test_http_failures_carry_status_and_response_without_retry(int $code): void
    {
        $http = new FakeHttpClient(new Response($code, [], '{"error":"request failed"}'));
        try {
            (new LiqPay('public', 'secret', httpClient: $http))->refund()->orderId('order')->amount(1)->send();
            self::fail('Expected HTTP exception');
        } catch (HttpException $e) {
            self::assertSame($code, $e->statusCode);
            self::assertSame('{"error":"request failed"}', $e->responseBody);
            self::assertCount(1, $http->requests);
        }
    }

    public function test_transport_failure_remains_distinct_and_is_not_retried(): void
    {
        $cause = new ConnectException('Connection timed out', new Request('POST', 'https://www.liqpay.ua/api/request'));
        $http = new FakeHttpClient($cause);
        try {
            (new LiqPay('public', 'secret', httpClient: $http))->refund()->orderId('order')->amount(1)->send();
            self::fail('Expected transport exception');
        } catch (TransportException $e) {
            self::assertSame($cause, $e->getPrevious());
            self::assertCount(1, $http->requests);
        }
    }

    public static function rawReports(): iterable
    {
        yield ['csv', "order_id,amount\norder,1.00\n"];
        yield ['xml', '<payments><payment amount="1.00"/></payments>'];
    }

    #[DataProvider('rawReports')]
    public function test_explicit_non_json_reports_remain_strings(string $format, string $body): void
    {
        $http = new FakeHttpClient(new Response(200, [], $body));
        $client = new LiqPay('public', 'secret', httpClient: $http);
        self::assertSame($body, $client->information()->reports()->respFormat($format)->dateFrom('1759276800000')->send());
        self::assertSame('*/*', $http->requests[0]->getHeaderLine('Accept'));
    }

    public function test_json_business_errors_remain_arrays_when_csv_was_requested(): void
    {
        $http = new FakeHttpClient(new Response(200, ['Content-Type' => 'application/json; charset=utf-8'], '{"result":"error","err_code":"invalid_date"}'));
        $client = new LiqPay('public', 'secret', httpClient: $http);
        self::assertSame(['result' => 'error', 'err_code' => 'invalid_date'], $client->information()->reports()->respFormat('csv')->send());
    }

    public function test_async_csv_report_returns_its_json_envelope(): void
    {
        $http = new FakeHttpClient(new Response(200, [], '{"result":"ok","register_token":123,"status":"processing"}'));
        $client = new LiqPay('public', 'secret', httpClient: $http);
        self::assertSame(['result' => 'ok', 'register_token' => 123, 'status' => 'processing'], $client->information()->compensationFile()->respFormat('csv')->date('2026-10-01')->send());
    }

    public function test_public_rates_do_not_receive_credentials(): void
    {
        $http = new FakeHttpClient(new Response(200, [], '[{"ccy":"USD","buy":"41.50000"}]'));
        $client = new LiqPay('public', 'secret', httpClient: $http);
        self::assertSame([['ccy' => 'USD', 'buy' => '41.50000']], $client->publicApi()->exchangeRates()->coursid(11)->send());
        self::assertSame('https://api.privatbank.ua/p24api/pubinfo?coursid=11&exchange=&json=', (string) $http->requests[0]->getUri());
    }
}
