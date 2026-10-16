# LiqPay PHP SDK — Fluent LiqPay API v7 Client

[![CI](https://github.com/andriichuk/liqpay-php-sdk/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/andriichuk/liqpay-php-sdk/actions/workflows/ci.yml)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](composer.json)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A fluent, framework-agnostic client for **LiqPay API v7**, requiring **PHP 8.2+**. Each operation has a concrete request class with typed methods and IDE completion. JSON responses are decoded into native PHP values, with objects represented as associative arrays.

This is an independent SDK. Its initial version has not been published to Packagist or tested against a live merchant account.

## Features

- 58 operations covering payments, refunds, subscriptions, invoices, tokens, transfers and reports.
- Immutable fluent request builders with typed setters and IDE completion.
- Documented PHPStan response array shapes with nested records and field comments.
- Configurable Guzzle transport or any PSR-18 client with PSR-17 factories.
- LiqPay API v7 signing, explicit v3 compatibility, and callback verification.
- Hosted checkout and widget payloads, payment splitting and fiscal receipt data.
- Framework-agnostic PHP 8.2+ library with native PHP response values.

[Endpoint coverage](docs/ENDPOINTS.md) · [Response shapes](docs/RESPONSES.md) · [Contributing](CONTRIBUTING.md) · [Security](SECURITY.md)

## Getting started

### Install from GitHub

The package is not on Packagist yet. Add its GitHub repository to your application's Composer configuration:

```bash
composer config repositories.liqpay vcs https://github.com/andriichuk/liqpay-php-sdk
composer require andriichuk/liqpay-php-sdk:dev-main
```

Include `vendor/autoload.php` when your application does not already load Composer. The examples below use `LIQPAY_PUBLIC_KEY` and `LIQPAY_PRIVATE_KEY` from your application's environment.

### Refund a payment

```php
use Andriichuk\LiqPay\LiqPay;

$liqpay = new LiqPay($_ENV['LIQPAY_PUBLIC_KEY'], $_ENV['LIQPAY_PRIVATE_KEY']);

$result = $liqpay->refund()
    ->orderId('order_id_1')
    ->amount('19.90')
    ->send();

$status = $result['status'] ?? null;
```

`send()` is the execution boundary. Setters build a request; they never make HTTP calls. This lets optional fields appear in any order. Checkout/widget builders instead produce a signed local payload using `payload()` or `send()`.

API v7 uses **SHA3-256** signatures. The older official PHP SDK and many documentation code samples still use API v3 and SHA-1. To reproduce a legacy call explicitly:

```php
$result = $liqpay->refund()
    ->orderId('order_id_1')
    ->version('3')
    ->send();
```

The current v7 refund parameter table marks `amount` as required, while the older v3 examples omit it. This SDK requires it for v7 and permits omission for v3. Version `7`, `3`, their string equivalents, and `ApiVersion::V7` / `ApiVersion::V3` are accepted. Other versions are rejected rather than signed with a guessed algorithm.

PHP 8.2 is the oldest security-supported PHP branch as of 16 October 2026; its upstream security support ends on 31 December 2026. The package supports PHP 8.2 through 8.x.

## HTTP configuration

Guzzle is included for the simple constructor. Configure its timeouts, proxy, TLS certificates, handlers, middleware, and other client-level settings through `Configuration`:

```php
use Andriichuk\LiqPay\Configuration;

$liqpay = new LiqPay($publicKey, $privateKey, configuration: new Configuration(
    httpOptions: [
        'timeout' => 15.0,
        'connect_timeout' => 5.0,
        'proxy' => 'http://proxy.example.com:8080',
        'verify' => '/path/to/ca-bundle.pem',
    ],
    userAgent: 'my-shop/1.0',
));
```

Or supply **any PSR-18 client** and optional **PSR-17 factories**, following the approach in the BlueSnap SDK:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$factory = new HttpFactory();
$liqpay = new LiqPay(
    $publicKey,
    $privateKey,
    httpClient: new Client(['timeout' => 10, 'connect_timeout' => 3]),
    requestFactory: $factory,
    streamFactory: $factory,
);
```

`httpOptions` configures only the built-in Guzzle client; configure an injected client yourself. Default timeouts are 30 seconds overall and 10 seconds to connect. PSR-18 Guzzle requests do not follow redirects and return unsuccessful HTTP responses for the SDK to handle. No automatic retries are added. Applications control middleware and retries, including reconciliation after an uncertain payment result.

`Configuration` also accepts `apiVersion`, `apiBaseUri`, `checkoutUrl`, `publicBaseUri`, `posDataUrl`, `posCallbackUrl`, and `posRequestUrl`. Endpoint overrides must be absolute HTTPS URLs. The documented checkout URL remains `/api/3/checkout` even when the signed payload uses version 7.

## Subscriptions and invoices

```php
$result = $liqpay->subscriptions()->create()
    ->orderId('membership-123')
    ->amount('29.00')
    ->currency('UAH')
    ->description('Monthly membership')
    ->card($cardNumber)
    ->cardCvv($cvv)
    ->cardExpMonth('12')
    ->cardExpYear('29')
    ->ip($customerIp)
    ->phone($customerPhone)
    ->subscribeDateStart('2026-11-01 10:00:00')
    ->subscribePeriodicity('month')
    ->serverUrl('https://shop.example.com/liqpay/callback')
    ->send();

$liqpay->subscriptions()->update()
    ->orderId('membership-123')
    ->amount('35.00')->currency('UAH')->description('Updated membership')
    ->send();

$liqpay->subscriptions()->cancel()->orderId('membership-123')->send();

$liqpay->invoices()->create()
    ->orderId('invoice-123')->amount('100.00')->currency('UAH')
    ->description('Invoice #123')->email($email)->phone($phone)
    ->send();

$liqpay->invoices()->cancel()->orderId('invoice-123')->send();
$units = $liqpay->invoices()->units()->language('en')->send();
```

`subscription()` and `invoice()` are shortcuts for the respective `create()` builder. The server-to-server card flows require the corresponding merchant access; hosted checkout is also available.

## Checkout and widgets

```php
$checkout = $liqpay->checkout()
    ->orderId('order-123')->amount('125.00')->currency('UAH')
    ->description('Order #123')->language('en')
    ->resultUrl('https://shop.example.com/thank-you')
    ->serverUrl('https://shop.example.com/liqpay/callback');

$payload = $checkout->payload(); // ['url' => ..., 'data' => ..., 'signature' => ...]
echo $checkout->form('Pay now'); // Escaped HTML form, no remote script injection.

$widgetPayload = $liqpay->widget()
    ->orderId('widget-123')->amount('50.00')->currency('UAH')
    ->description('Widget purchase')->payload();
```

Pass `data` and `signature` to LiqPay's browser SDK to render a widget. Browser SDKs and frontend components are external to this PHP package. `donation()` and `authorization()` provide hosted `paydonate` and `auth` builders. Checkout also supports `action('hold')` and `action('subscribe')`.

For splitting and fiscal receipts, pass native arrays:

```php
$checkout = $checkout->splitRules([
    ['public_key' => 'recipient-key', 'amount' => '25.00', 'commission_payer' => 'sender'],
])->rroInfo([
    'items' => [['id' => 1, 'amount' => 1, 'price' => 125, 'cost' => 125]],
    'delivery_emails' => [$email],
]);
```

`splitRules()` encodes arrays to the JSON string required by that API field. Nested objects such as `rroInfo()` remain arrays in the payload. There is no separate split-payment endpoint in the current splitting guide.

## Other operations

```php
$status = $liqpay->status()->orderId('order-123')->send();
$liqpay->capture()->orderId('order-123')->amount('100.00')->send();
$liqpay->confirmations()->otp()->confirmToken($token)->otp($otp)->send();
$liqpay->confirmations()->cvv()->confirmToken($token)->cardCvv($cvv)->send();
$liqpay->confirmations()->threeDs()->confirmToken($token)->send();

$liqpay->tokens()->create()->isDebit(true)->isCredit(false)
    ->card($cardNumber)->cardCvv($cvv)->cardExpMonth('12')->cardExpYear('29')->send();
$liqpay->tokens()->update()->cardToken($cardToken)->cardTokenAction('SUSPEND')->send();

$reports = $liqpay->information()->reports()
    ->dateFrom('1759276800000')->dateTo('1761955199999')->send();
$csv = $liqpay->information()->reports()->respFormat('csv')->send();

$rates = $liqpay->publicApi()->exchangeRates()->coursid(11)->send();
$archive = $liqpay->publicApi()->exchangeArchive()->date('01.10.2026')->send();
```

See the [complete endpoint coverage matrix](docs/ENDPOINTS.md) for all 58 operations, including partner and outbound POS APIs.

## Callback verification

```php
$payload = $liqpay->callback()->verify($_POST['data'], $_POST['signature']);
// Signature verified, merchant key matched; $payload is an associative array.
```

The expected version defaults to the client configuration. Pass `version: 3` only for callbacks belonging to a legacy integration. Verification never automatically falls back to SHA-1 based on unverified callback data. POS callbacks use `verifyPos($data, $signature)` because their protocol omits merchant `public_key` and API `version`.

Applications should check order, amount, currency and final status, and deduplicate callback processing before changing their order state.

## Response array shapes

The response annotations require PHPStan 2.3.1+ for inline field comments. Every operation declares its PHPStan response aliases directly on the existing request class, with field comments and a link to its LiqPay source. Shared nested shapes are imported from the SDK classes that own them. The fluent builders preserve the alias through `send()`; responses remain native arrays. Nested token details, report rows, MCC data, exchange rates and POS records are shaped too.

```php
$response = $liqpay->refund()->orderId('order-123')->amount('10.00')->send();
// PHPStan knows the refund fields and their original wire types.
$paymentId = $response['payment_id'] ?? null; // int|numeric-string|null
$waiting = $response['wait_amount'] ?? null; // bool|'true'|'false'|null
```

Fields omitted by some statuses or error responses are optional. CSV/XML report operations use array-shape-or-string unions. See [response contracts and aliases](docs/RESPONSES.md) for the type definitions and documentation gaps. The aliases describe the API contract without adding runtime response validation or conversion.

## Response and error behavior

- JSON objects become associative arrays; JSON arrays become PHP arrays. Booleans, nulls, numeric strings, integers and floats retain their decoded types. Integers exceeding PHP's range are preserved as strings to avoid precision loss.
- CSV/XML report responses remain strings. A JSON response identified by its content type still decodes normally, including business errors. Asynchronous file-report creation returns its original JSON envelope.
- LiqPay business failures returned with HTTP 2xx, including `result: error`, remain the original response. Inspect `result`, `status` and `err_code` as appropriate for the operation.
- HTTP failures throw `HttpException`, exposing `statusCode` and `responseBody`. PSR client failures throw `TransportException`; invalid JSON throws `InvalidResponseException`. Failed callback verification throws `InvalidSignatureException`.
- Missing required parameters, incomplete funding alternatives, invalid amounts, overlong order IDs and unsupported versions throw `InvalidArgumentException` before transmission. Merchant-specific eligibility and remaining conditional API rules are validated by LiqPay.

## Request reuse and extension fields

Builders are immutable. Keep the returned object when setting fields in separate statements:

```php
$template = $liqpay->refund()->amount('10.00');
$first = $template->orderId('first');
$second = $template->orderId('second');

$request = $first->withParameter('new_api_option', ['enabled' => true]);
$parameters = $request->toArray(); // Inspect without sending; credentials are added at signing time.
```

`withParameters()` accepts a native array for additional API fields. Reserved fields such as credentials, `action`, `version`, `data` and `signature` cannot be overridden this way.

## Development

```bash
git clone https://github.com/andriichuk/liqpay-php-sdk.git
cd liqpay-php-sdk
composer install
composer check
```

PHP CS Fixer uses the official [Laravel Pint Laravel preset](https://github.com/laravel/pint/blob/8c83db2d36638a3da60f63ff3c94698b64e942a6/resources/presets/laravel.php), saved in `tools/php-cs-fixer/laravel.php` with its MIT license. It formats `src/`, `tests/`, and the formatter configuration. Run `composer format` to apply fixes or `composer format:check` to check without editing files. The formatting check is included in `composer check` and CI.

Tests use fake PSR clients or Guzzle's mock handler; they need no credentials and make no live payment requests. CI runs PHP 8.2, 8.3, 8.4 and 8.5, plus a PHP 8.2 run with the lowest supported dependency versions. Static analysis runs at PHPStan's maximum level and checks response-type inference through all 58 fluent entry points plus callbacks.

The facade composes independent request builders, an executor, signer, payload codec and PSR transport. Modules depend on `RequestExecutorInterface`; the executor depends on `TransportInterface` and `SignerInterface`; HTTP transport depends on PSR-18/17. Concrete operation classes expose the documented payload fields without runtime magic methods or response models.

## Support and license

Report reproducible bugs through [GitHub Issues](https://github.com/andriichuk/liqpay-php-sdk/issues). Read [CONTRIBUTING.md](CONTRIBUTING.md) before submitting a pull request and [SECURITY.md](SECURITY.md) for private vulnerability reports.

Documentation sources include the [LiqPay API](https://www.liqpay.ua/en/doc/api/internet_acquiring) and [official PHP SDK](https://github.com/liqpay/sdk-php). This SDK is maintained independently by [Serhii Andriichuk](https://github.com/andriichuk).

Licensed under the [MIT license](LICENSE). The bundled Laravel formatter preset retains its [upstream MIT license](tools/php-cs-fixer/LICENSE.md).
