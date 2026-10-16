<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_status
 *
 * @phpstan-type PosReceiver array{
 *     id?: string, // Receiver identifier.
 *     name?: string, // Venue, receiver or table name.
 *     okpo?: string|null, // Company registration code.
 *     receiver_status?: string, // Receiver state: new, active, suspended or deleted.
 * }
 * @phpstan-type PosReceiversStatusResponse array{
 *     status: string, // Status: success, error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     receivers?: list<PosReceiver>, // Payment receiver records.
 * }
 *
 * @extends AbstractRequest<PosReceiversStatusResponse>
 */
final class PosReceiversStatusRequest extends AbstractRequest
{
    protected const ACTION = 'get_status_receivers';

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
