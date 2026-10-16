<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/receive_a_receipt
 *
 * @phpstan-type ReceiptResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 *
 * @extends AbstractRequest<ReceiptResponse>
 */
final class ReceiptRequest extends AbstractRequest
{
    protected const ACTION = 'ticket';

    protected const REQUIRED = ['email', 'order_id'];

    public function email(string $value): static
    {
        return $this->withParameter('email', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    public function paymentId(int|string $value): static
    {
        return $this->withParameter('payment_id', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }
}
