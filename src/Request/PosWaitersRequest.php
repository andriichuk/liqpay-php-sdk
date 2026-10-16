<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/POS/venue_creation
 *
 * @phpstan-type PosWaitersResponse array{
 *     status: string, // Acknowledgement state: success or error.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 * }
 *
 * @extends AbstractRequest<PosWaitersResponse>
 */
final class PosWaitersRequest extends AbstractRequest
{
    protected const ACTION = 'get_waiters';

    protected const ENDPOINT = 'posData';

    protected const REQUIRED = ['req_id', 'id_company_in_pos', 'waiters'];

    public function reqId(string $value): static
    {
        return $this->withParameter('req_id', $value);
    }

    public function idCompanyInPos(string $value): static
    {
        return $this->withParameter('id_company_in_pos', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function waiters(array $value): static
    {
        return $this->withParameter('waiters', $value);
    }
}
