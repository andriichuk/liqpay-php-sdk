<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/info_merchant
 *
 * @phpstan-type MerchantInfoResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     blocked?: string, // Company blocking status.
 *     category?: string|null, // Merchant business category.
 *     company_name?: string, // Full company name.
 *     create_date?: int|string, // Creation date.
 *     description?: string, // Payment or company description.
 *     email?: string, // Company email.
 *     logo?: string|null, // Company logo.
 *     mcc?: string, // Merchant category code.
 *     mfo?: string|null, // Company bank code.
 *     name?: string, // Company name.
 *     okpo?: string|null, // Company registration code.
 *     phone?: string, // Company phone.
 *     public_key?: string, // Merchant public key.
 *     public_phone?: string|null, // Public contact phone.
 *     refund_number?: string|null, // Settlement card, account or terminal.
 *     refund_way?: string|null, // Settlement method.
 *     status_description?: string, // Company status explanation, localized by language.
 *     comment?: list<mixed>, // Merchant review operator comments; item structure is unspecified.
 *     link?: string, // Merchant business dashboard link.
 *     update_date?: int|string, // Company information update date.
 *     url?: string, // Company or payment URL.
 * }
 *
 * @extends AbstractRequest<MerchantInfoResponse>
 */
final class MerchantInfoRequest extends AbstractRequest
{
    protected const ACTION = 'agent_info_merchant';

    protected const REQUIRED = ['merchant_public_key'];

    public function merchantPublicKey(string $value): static
    {
        return $this->withParameter('merchant_public_key', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }
}
