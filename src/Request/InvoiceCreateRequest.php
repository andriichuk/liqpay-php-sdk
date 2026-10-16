<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice
 *
 * @phpstan-type InvoiceCreateResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, success, invoice_wait.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     action?: string, // Operation type.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     currency?: string, // Payment currency.
 *     description?: string, // Payment or company description.
 *     href?: string, // Invoice payment link.
 *     id?: int|numeric-string, // Identifier.
 *     order_id?: string, // Merchant order identifier.
 *     receiver_type?: string, // Invoice delivery channel.
 *     receiver_value?: string, // Invoice destination for the selected channel.
 *     token?: string, // Payment token.
 * }
 *
 * @extends AbstractRequest<InvoiceCreateResponse>
 */
final class InvoiceCreateRequest extends AbstractRequest
{
    protected const ACTION = 'invoice_send';

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id', 'email', 'phone'];

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

    public function email(string $value): static
    {
        return $this->withParameter('email', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function rroInfo(array $value): static
    {
        return $this->withParameter('rro_info', $value);
    }

    public function actionPayment(string $value): static
    {
        return $this->withParameter('action_payment', $value);
    }

    public function expiredDate(string $value): static
    {
        return $this->withParameter('expired_date', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function goods(array|string $value): static
    {
        return $this->withParameter('goods', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function resultUrl(string $value): static
    {
        return $this->withParameter('result_url', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }
}
