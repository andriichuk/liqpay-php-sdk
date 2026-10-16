<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_creation
 *
 * @phpstan-type PosTablesResponse array{
 *     status: string, // Acknowledgement state: success or error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 *
 * @extends AbstractRequest<PosTablesResponse>
 */
final class PosTablesRequest extends AbstractRequest
{
    protected const ACTION = 'get_tables';

    protected const ENDPOINT = 'posData';

    protected const REQUIRED = ['req_id', 'id_company_in_pos', 'halls'];

    public function reqId(string $value): static
    {
        return $this->withParameter('req_id', $value);
    }

    public function idCompanyInPos(string $value): static
    {
        return $this->withParameter('id_company_in_pos', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function halls(array $value): static
    {
        return $this->withParameter('halls', $value);
    }
}
