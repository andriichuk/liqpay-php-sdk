<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/qr
 *
 * @phpstan-type StaticQrResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Status: QR.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     id?: int|numeric-string, // Identifier.
 *     shop_id?: int|numeric-string, // Merchant shop identifier.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     currency?: string, // Payment currency.
 *     description?: string, // Payment or company description.
 *     create_date?: int|string, // Creation date.
 *     final_date?: string, // QR payment expiry.
 *     qrdata?: string, // QR payment data.
 *     url?: string, // Company or payment URL.
 * }
 *
 * @extends AbstractRequest<StaticQrResponse>
 */
final class StaticQrRequest extends AbstractRequest
{
    protected const ACTION = 'staticQrCreate';

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id'];

    public function amount(int|float|string $value): static
    {
        return $this->withParameter('amount', $value);
    }

    public function currency(string $value): static
    {
        return $this->withParameter('currency', $value);
    }

    public function description(string $value): static
    {
        return $this->withParameter('description', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    public function finalDate(string $value): static
    {
        return $this->withParameter('final_date', $value);
    }
}
