<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/order_payment
 *
 * @phpstan-type PosSplitBillsResponse array{
 *     status: string, // Acknowledgement state: success or error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 *
 * @extends AbstractRequest<PosSplitBillsResponse>
 */
final class PosSplitBillsRequest extends AbstractRequest
{
    protected const ACTION = 'split_bills';

    protected const ENDPOINT = 'posCallback';

    protected const REQUIRED = ['status', 'req_id', 'id_company_in_pos', 'new_bill_id'];

    public function status(string $value): static
    {
        return $this->withParameter('status', $value);
    }

    public function reqId(string $value): static
    {
        return $this->withParameter('req_id', $value);
    }

    public function idCompanyInPos(string $value): static
    {
        return $this->withParameter('id_company_in_pos', $value);
    }

    public function newBillId(string $value): static
    {
        return $this->withParameter('new_bill_id', $value);
    }
}
