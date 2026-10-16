<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_status
 *
 * @phpstan-type PosWaiter array{
 *     id?: string, // Waiter identifier.
 *     fio?: string, // Waiter full name.
 *     phone?: string, // Company phone.
 *     waiter_status?: string, // Waiter state: new, active, suspended or deleted.
 * }
 * @phpstan-type PosWaitersStatusResponse array{
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     waiters?: list<PosWaiter>, // Waiter records.
 * }
 *
 * @extends AbstractRequest<PosWaitersStatusResponse>
 */
final class PosWaitersStatusRequest extends AbstractRequest
{
    protected const ACTION = 'get_status_waiters';

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
