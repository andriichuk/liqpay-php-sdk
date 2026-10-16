<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay;

use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Crypto\PayloadCodec;
use Andriichuk\LiqPay\Crypto\Signer;
use Andriichuk\LiqPay\Http\Psr18Transport;
use Andriichuk\LiqPay\Http\RequestExecutor;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use InvalidArgumentException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @see https://www.liqpay.ua/en/doc/api/errors
 *
 * @phpstan-type ApiError array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 */
final class LiqPay
{
    public readonly Configuration $configuration;

    private readonly RequestExecutorInterface $executor;

    private readonly Callback $callback;

    public function __construct(
        string $publicKey,
        #[\SensitiveParameter] string $privateKey,
        ?ClientInterface $httpClient = null,
        ?Configuration $configuration = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
    ) {
        if (trim($publicKey) === '') {
            throw new InvalidArgumentException('Public key must not be empty.');
        }
        $this->configuration = $configuration ?? new Configuration;
        $factory = new HttpFactory;
        $httpClient ??= new Client(array_replace([
            'timeout' => 30.0,
            'connect_timeout' => 10.0,
        ], $this->configuration->httpOptions));
        $transport = new Psr18Transport($httpClient, $requestFactory ?? $factory, $streamFactory ?? $factory, $this->configuration->userAgent);
        $signer = new Signer($privateKey);
        $codec = new PayloadCodec;
        $this->executor = new RequestExecutor($publicKey, $this->configuration, $transport, $signer, $codec);
        $this->callback = new Callback($publicKey, $signer, $codec, $this->configuration->apiVersion);
    }

    public function callback(): Callback
    {
        return $this->callback;
    }

    public function refund(): Request\RefundRequest
    {
        return new Request\RefundRequest($this->executor, $this->configuration->apiVersion);
    }

    public function payment(): Request\PaymentRequest
    {
        return new Request\PaymentRequest($this->executor, $this->configuration->apiVersion);
    }

    public function checkout(): Request\CheckoutRequest
    {
        return new Request\CheckoutRequest($this->executor, $this->configuration->apiVersion);
    }

    public function widget(): Request\WidgetRequest
    {
        return new Request\WidgetRequest($this->executor, $this->configuration->apiVersion);
    }

    public function donation(): Request\DonationRequest
    {
        return new Request\DonationRequest($this->executor, $this->configuration->apiVersion);
    }

    public function authorization(): Request\AuthorizationRequest
    {
        return new Request\AuthorizationRequest($this->executor, $this->configuration->apiVersion);
    }

    public function privatPay(): Request\PrivatPayRequest
    {
        return new Request\PrivatPayRequest($this->executor, $this->configuration->apiVersion);
    }

    public function applePay(): Request\ApplePayRequest
    {
        return new Request\ApplePayRequest($this->executor, $this->configuration->apiVersion);
    }

    public function googlePay(): Request\GooglePayRequest
    {
        return new Request\GooglePayRequest($this->executor, $this->configuration->apiVersion);
    }

    public function tokenPayment(): Request\TokenPaymentRequest
    {
        return new Request\TokenPaymentRequest($this->executor, $this->configuration->apiVersion);
    }

    public function cash(): Request\CashRequest
    {
        return new Request\CashRequest($this->executor, $this->configuration->apiVersion);
    }

    public function qr(): Request\QrRequest
    {
        return new Request\QrRequest($this->executor, $this->configuration->apiVersion);
    }

    public function staticQr(): Request\StaticQrRequest
    {
        return new Request\StaticQrRequest($this->executor, $this->configuration->apiVersion);
    }

    public function hold(): Request\HoldRequest
    {
        return new Request\HoldRequest($this->executor, $this->configuration->apiVersion);
    }

    public function capture(): Request\CaptureRequest
    {
        return new Request\CaptureRequest($this->executor, $this->configuration->apiVersion);
    }

    public function dcc(): Request\DccRequest
    {
        return new Request\DccRequest($this->executor, $this->configuration->apiVersion);
    }

    public function subscription(): Request\SubscriptionCreateRequest
    {
        return new Request\SubscriptionCreateRequest($this->executor, $this->configuration->apiVersion);
    }

    public function invoice(): Request\InvoiceCreateRequest
    {
        return new Request\InvoiceCreateRequest($this->executor, $this->configuration->apiVersion);
    }

    public function status(): Request\StatusRequest
    {
        return new Request\StatusRequest($this->executor, $this->configuration->apiVersion);
    }

    public function subscriptions(): Module\Subscriptions
    {
        return new Module\Subscriptions($this->executor, $this->configuration->apiVersion);
    }

    public function invoices(): Module\Invoices
    {
        return new Module\Invoices($this->executor, $this->configuration->apiVersion);
    }

    public function tokens(): Module\Tokens
    {
        return new Module\Tokens($this->executor, $this->configuration->apiVersion);
    }

    public function confirmations(): Module\Confirmations
    {
        return new Module\Confirmations($this->executor, $this->configuration->apiVersion);
    }

    public function information(): Module\Information
    {
        return new Module\Information($this->executor, $this->configuration->apiVersion);
    }

    public function transfers(): Module\Transfers
    {
        return new Module\Transfers($this->executor, $this->configuration->apiVersion);
    }

    public function partnerships(): Module\Partnerships
    {
        return new Module\Partnerships($this->executor, $this->configuration->apiVersion);
    }

    public function publicApi(): Module\PublicApi
    {
        return new Module\PublicApi($this->executor, $this->configuration->apiVersion);
    }

    public function pos(): Module\Pos
    {
        return new Module\Pos($this->executor, $this->configuration->apiVersion);
    }
}
