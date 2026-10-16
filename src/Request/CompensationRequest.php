<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/register
 *
 * @phpstan-type CompensationJson array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     data?: list<CompensationRecord>, // Report records.
 * }
 * @phpstan-type CompensationRecord array{
 *     compensation_id?: int|numeric-string, // Settlement identifier.
 *     create_date?: int|string, // Creation date.
 * }
 * @phpstan-type CompensationResponse CompensationJson|string
 *
 * @extends AbstractRequest<CompensationResponse>
 */
final class CompensationRequest extends AbstractRequest
{
    protected const ACTION = 'reports_compensation';

    public function compensationId(string $value): static
    {
        return $this->withParameter('compensation_id', $value);
    }

    public function respFormat(string $value): static
    {
        return $this->withParameter('resp_format', $value);
    }

    public function date(string $value): static
    {
        return $this->withParameter('date', $value);
    }
}
