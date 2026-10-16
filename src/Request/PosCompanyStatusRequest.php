<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_status
 *
 * @phpstan-type PosCompanyStatusResponse array{
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     companies?: list<PosCompany>, // Venue company records.
 * }
 * @phpstan-type PosCompany array{
 *     name?: string, // Venue, receiver or table name.
 *     address?: string, // Venue address.
 *     status_company?: string, // Company state: new, active, suspended or deleted.
 * }
 *
 * @extends AbstractRequest<PosCompanyStatusResponse>
 */
final class PosCompanyStatusRequest extends AbstractRequest
{
    protected const ACTION = 'get_status_company';

    protected const ENDPOINT = 'posData';

    protected const REQUIRED = ['pos_name', 'id_company_in_pos'];

    public function posName(string $value): static
    {
        return $this->withParameter('pos_name', $value);
    }

    public function idCompanyInPos(string $value): static
    {
        return $this->withParameter('id_company_in_pos', $value);
    }
}
