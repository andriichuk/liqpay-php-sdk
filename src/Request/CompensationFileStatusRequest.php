<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/register
 *
 * @phpstan-type CompensationFileStatusResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     filelink?: string, // Temporary report download URL.
 * }
 *
 * @extends AbstractRequest<CompensationFileStatusResponse>
 */
final class CompensationFileStatusRequest extends AbstractRequest
{
    protected const ACTION = 'reports_compensation_file_status';

    protected const REQUIRED = ['register_token'];

    public function registerToken(int|string $value): static
    {
        return $this->withParameter('register_token', $value);
    }
}
