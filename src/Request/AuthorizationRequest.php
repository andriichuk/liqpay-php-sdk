<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/checkout
 *
 * @phpstan-import-type CheckoutPayload from \Andriichuk\LiqPay\Contract\RequestExecutorInterface
 *
 * @phpstan-type AuthorizationResponse CheckoutPayload
 */
final class AuthorizationRequest extends AbstractCheckoutRequest
{
    protected const ACTION = 'auth';

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id'];

    public function amount(int|float|string $value): static
    {
        return $this->withParameter('amount', $value);
    }

    public function currency(string $value): static
    {
        return $this->withParameter('currency', $value);
    }

    public function description(string $value): static
    {
        return $this->withParameter('description', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function rroInfo(array $value): static
    {
        return $this->withParameter('rro_info', $value);
    }

    public function expiredDate(string $value): static
    {
        return $this->withParameter('expired_date', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function paytypes(string $value): static
    {
        return $this->withParameter('paytypes', $value);
    }

    public function resultUrl(string $value): static
    {
        return $this->withParameter('result_url', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    public function verifycode(string $value): static
    {
        return $this->withParameter('verifycode', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function splitRules(array|string $value): static
    {
        $value = is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value;

        return $this->withParameter('split_rules', $value);
    }

    public function senderAddress(string $value): static
    {
        return $this->withParameter('sender_address', $value);
    }

    public function senderCity(string $value): static
    {
        return $this->withParameter('sender_city', $value);
    }

    public function senderCountryCode(string $value): static
    {
        return $this->withParameter('sender_country_code', $value);
    }

    public function senderFirstName(string $value): static
    {
        return $this->withParameter('sender_first_name', $value);
    }

    public function senderLastName(string $value): static
    {
        return $this->withParameter('sender_last_name', $value);
    }

    public function senderPostalCode(string $value): static
    {
        return $this->withParameter('sender_postal_code', $value);
    }

    public function subscribe(bool|string|int $value): static
    {
        return $this->withParameter('subscribe', $value);
    }

    public function subscribeDateStart(string $value): static
    {
        return $this->withParameter('subscribe_date_start', $value);
    }

    public function subscribePeriodicity(string $value): static
    {
        return $this->withParameter('subscribe_periodicity', $value);
    }

    public function customer(string $value): static
    {
        return $this->withParameter('customer', $value);
    }

    public function recurringbytoken(bool|string|int $value): static
    {
        return $this->withParameter('recurringbytoken', $value);
    }

    public function customerUserId(string $value): static
    {
        return $this->withParameter('customer_user_id', $value);
    }

    public function dae(string $value): static
    {
        return $this->withParameter('dae', $value);
    }

    public function info(string $value): static
    {
        return $this->withParameter('info', $value);
    }

    public function productCategory(string $value): static
    {
        return $this->withParameter('product_category', $value);
    }

    public function productDescription(string $value): static
    {
        return $this->withParameter('product_description', $value);
    }

    public function productName(string $value): static
    {
        return $this->withParameter('product_name', $value);
    }

    public function productUrl(string $value): static
    {
        return $this->withParameter('product_url', $value);
    }
}
