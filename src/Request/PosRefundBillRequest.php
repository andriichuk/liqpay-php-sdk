<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/order_payment
 *
 * @phpstan-type PosRefundBillResponse array{
 *     req_id?: string, // Original request correlation identifier.
 *     action?: string, // Operation type.
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     payments_success?: list<PosRefundTransaction>, // Successful refund transactions.
 *     payments_error?: list<PosRefundTransaction>, // Failed refund transactions.
 * }
 * @phpstan-type PosRefundTransaction array{
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     receiver_id?: string, // Receiver identifier.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     error?: string, // Refund error information.
 *     err_code?: string, // Error code.
 * }
 *
 * @extends AbstractRequest<PosRefundBillResponse>
 */
final class PosRefundBillRequest extends AbstractRequest
{
    protected const ACTION = 'refund_bill';

    protected const ENDPOINT = 'posRequest';

    protected const REQUIRED = ['req_id', 'pos_system', 'merchant_id', 'payment_id'];

    public function reqId(string $value): static
    {
        return $this->withParameter('req_id', $value);
    }

    public function posSystem(string $value): static
    {
        return $this->withParameter('pos_system', $value);
    }

    public function merchantId(string $value): static
    {
        return $this->withParameter('merchant_id', $value);
    }

    public function paymentId(int|string $value): static
    {
        return $this->withParameter('payment_id', $value);
    }

    public function billNumber(string $value): static
    {
        return $this->withParameter('bill_number', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function receivers(array $value): static
    {
        return $this->withParameter('receivers', $value);
    }
}
