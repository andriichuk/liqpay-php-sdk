<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

use Andriichuk\LiqPay\ApiVersion;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/refund
 *
 * @phpstan-type RefundResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, reversed, success.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     wait_amount?: bool|'true'|'false', // True for refund from future receipts; false for merchant balance.
 *     action?: string, // Operation type.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 * }
 *
 * @extends AbstractRequest<RefundResponse>
 */
final class RefundRequest extends AbstractRequest
{
    protected const ACTION = 'refund';

    protected const REQUIRED = ['order_id'];

    public function amount(int|float|string $value): static
    {
        return $this->withParameter('amount', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    protected function validate(): void
    {
        parent::validate();
        if ($this->apiVersion === ApiVersion::V7 && ! isset($this->parameters['amount'])) {
            throw new \InvalidArgumentException('API v7 refunds require amount.');
        }
    }
}
