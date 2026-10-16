<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice
 *
 * @phpstan-type InvoiceCancelResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     invoice_id?: int|numeric-string, // Invoice identifier.
 * }
 *
 * @extends AbstractRequest<InvoiceCancelResponse>
 */
final class InvoiceCancelRequest extends AbstractRequest
{
    protected const ACTION = 'invoice_cancel';

    protected const REQUIRED = ['order_id'];

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }
}
