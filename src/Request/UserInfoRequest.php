<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/info_user
 *
 * @phpstan-type UserInfoResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     blocked?: string, // Company blocking status.
 *     create_date?: int|string, // Creation date.
 *     description?: string, // Payment or company description.
 *     email?: string, // Company email.
 *     logo?: string|null, // Company logo.
 *     name?: string, // Company name.
 *     public_key?: string, // Merchant public key.
 *     role?: string, // User role.
 *     public_phone?: string|null, // Public contact phone.
 *     update_date?: int|string, // Company information update date.
 *     url?: string, // Company or payment URL.
 * }
 *
 * @extends AbstractRequest<UserInfoResponse>
 */
final class UserInfoRequest extends AbstractRequest
{
    protected const ACTION = 'agent_info_user';

    protected const REQUIRED = ['phone'];

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }
}
