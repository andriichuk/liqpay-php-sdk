<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/shop_create
 *
 * @phpstan-type MerchantRegisterResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     activation_status?: int|numeric-string, // Company activation: 5 active, 6 blocked.
 *     company_name?: string, // Full company name.
 *     create_date?: int|string, // Creation date.
 *     email?: string, // Company email.
 *     name?: string, // Company name.
 *     okpo?: string|null, // Company registration code.
 *     phone?: string, // Company phone.
 *     public_key?: string, // Merchant public key.
 *     refund_number?: string|null, // Settlement card, account or terminal.
 *     update_date?: int|string, // Company information update date.
 *     url?: string, // Company or payment URL.
 * }
 *
 * @extends AbstractRequest<MerchantRegisterResponse>
 */
final class MerchantRegisterRequest extends AbstractRequest
{
    protected const ACTION = 'agent_shop_register';

    protected const REQUIRED = ['phone', 'email', 'name', 'iban', 'okpo', 'company', 'mcc_code'];

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }

    public function email(string $value): static
    {
        return $this->withParameter('email', $value);
    }

    public function name(string $value): static
    {
        return $this->withParameter('name', $value);
    }

    public function urlSite(string $value): static
    {
        return $this->withParameter('url_site', $value);
    }

    public function urlAppIphone(string $value): static
    {
        return $this->withParameter('url_app_iphone', $value);
    }

    public function urlAppAndroid(string $value): static
    {
        return $this->withParameter('url_app_android', $value);
    }

    public function telegram(string $value): static
    {
        return $this->withParameter('telegram', $value);
    }

    public function viber(string $value): static
    {
        return $this->withParameter('viber', $value);
    }

    public function instagram(string $value): static
    {
        return $this->withParameter('instagram', $value);
    }

    public function facebook(string $value): static
    {
        return $this->withParameter('facebook', $value);
    }

    public function iban(string $value): static
    {
        return $this->withParameter('iban', $value);
    }

    public function okpo(string $value): static
    {
        return $this->withParameter('okpo', $value);
    }

    public function company(string $value): static
    {
        return $this->withParameter('company', $value);
    }

    public function mccCode(int|string $value): static
    {
        return $this->withParameter('mcc_code', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function docs(array $value): static
    {
        return $this->withParameter('docs', $value);
    }

    public function amountProcentAgent(int|float|string $value): static
    {
        return $this->withParameter('amount_procent_agent', $value);
    }

    public function amountStaticAgent(int|float|string $value): static
    {
        return $this->withParameter('amount_static_agent', $value);
    }

    public function currencyStaticAgent(string $value): static
    {
        return $this->withParameter('currency_static_agent', $value);
    }

    public function canReports(bool|string|int $value): static
    {
        return $this->withParameter('can_reports', $value);
    }

    public function canCheckoutEdit(bool|string|int $value): static
    {
        return $this->withParameter('can_checkout_edit', $value);
    }

    public function logo(string $value): static
    {
        return $this->withParameter('logo', $value);
    }

    public function urlCallbackStatus(string $value): static
    {
        return $this->withParameter('url_callback_status', $value);
    }

    public function lawOkpo(string $value): static
    {
        return $this->withParameter('law_okpo', $value);
    }

    public function lawName(string $value): static
    {
        return $this->withParameter('law_name', $value);
    }

    public function lawIban(string $value): static
    {
        return $this->withParameter('law_iban', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function lawContacts(array $value): static
    {
        return $this->withParameter('law_contacts', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function lawCtoInfo(array $value): static
    {
        return $this->withParameter('law_cto_info', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function lawOwnersInfo(array $value): static
    {
        return $this->withParameter('law_owners_info', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function lawCoOwnersInfo(array $value): static
    {
        return $this->withParameter('law_co_owners_info', $value);
    }
}
