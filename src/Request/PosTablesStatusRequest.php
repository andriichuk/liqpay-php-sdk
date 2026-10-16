<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_status
 *
 * @phpstan-type PosTable array{
 *     id?: string, // Table identifier.
 *     name?: string, // Venue, receiver or table name.
 *     hall_name?: string, // Hall name.
 *     qr_code?: string, // Payment QR code.
 *     table_status?: string, // Table or QR state.
 * }
 * @phpstan-type PosTablesStatusResponse array{
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     tables?: list<PosTable>, // Venue table records.
 * }
 *
 * @extends AbstractRequest<PosTablesStatusResponse>
 */
final class PosTablesStatusRequest extends AbstractRequest
{
    protected const ACTION = 'get_status_tables';

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
