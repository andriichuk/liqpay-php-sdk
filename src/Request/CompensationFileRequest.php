<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/register
 *
 * @phpstan-type CompensationFileResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     register_token?: int|string, // Report token for polling; examples use filenames.
 * }
 *
 * @extends AbstractRequest<CompensationFileResponse>
 */
final class CompensationFileRequest extends AbstractRequest
{
    protected const ACTION = 'reports_compensation_file';

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

    public function type(string $value): static
    {
        return $this->withParameter('type', $value);
    }
}
