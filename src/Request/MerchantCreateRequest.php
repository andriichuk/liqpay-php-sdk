<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/shop_create
 *
 * @phpstan-type MerchantCreateResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: success.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     private_key?: string, // Merchant private key returned when provisioning a shop.
 *     public_key?: string, // Merchant public key.
 * }
 *
 * @extends AbstractRequest<MerchantCreateResponse>
 */
final class MerchantCreateRequest extends AbstractRequest
{
    protected const ACTION = 'agent_shop_create';

    protected const REQUIRED = ['description', 'email', 'name', 'phone', 'site'];

    public function description(string $value): static
    {
        return $this->withParameter('description', $value);
    }

    public function email(string $value): static
    {
        return $this->withParameter('email', $value);
    }

    public function name(string $value): static
    {
        return $this->withParameter('name', $value);
    }

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }

    public function site(string $value): static
    {
        return $this->withParameter('site', $value);
    }

    public function iban(string $value): static
    {
        return $this->withParameter('iban', $value);
    }

    public function company(string $value): static
    {
        return $this->withParameter('company', $value);
    }

    public function okpo(string $value): static
    {
        return $this->withParameter('okpo', $value);
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

    public function publicPhone(string $value): static
    {
        return $this->withParameter('public_phone', $value);
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
