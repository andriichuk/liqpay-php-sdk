<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_status
 *
 * @phpstan-import-type PosReceiver from \Andriichuk\LiqPay\Request\PosReceiversStatusRequest
 * @phpstan-import-type PosWaiter from \Andriichuk\LiqPay\Request\PosWaitersStatusRequest
 *
 * @phpstan-type PosAllCompaniesStatusResponse array{
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     name?: string, // Venue, receiver or table name.
 *     address?: string, // Venue address.
 *     status_company?: string, // Company state: new, active, suspended or deleted.
 *     receivers?: list<PosReceiver>, // Payment receiver records.
 *     waiters?: list<PosWaiter>, // Waiter records.
 * }
 *
 * @extends AbstractRequest<PosAllCompaniesStatusResponse>
 */
final class PosAllCompaniesStatusRequest extends AbstractRequest
{
    protected const ACTION = 'get_all_status_company';

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
