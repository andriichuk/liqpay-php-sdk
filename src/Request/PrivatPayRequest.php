<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/privat_pay
 *
 * @phpstan-type PrivatPayResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 *
 * @extends AbstractRequest<PrivatPayResponse>
 */
final class PrivatPayRequest extends AbstractRequest
{
    protected const ACTION = 'payment_prepare';

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

    public function actionPayment(string $value): static
    {
        return $this->withParameter('action_payment', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function resultUrl(string $value): static
    {
        return $this->withParameter('result_url', $value);
    }
}
