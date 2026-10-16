<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/subscription
 *
 * @phpstan-type SubscriptionCreateResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, reversed, subscribed, success, cvv_verify, otp_verify, wait_accept, wait_secure.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     acq_id?: int|numeric-string, // Acquirer identifier.
 *     action?: string, // Operation type.
 *     agent_commission?: int|float|numeric-string, // Agent fee in payment currency.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     authcode_debit?: string, // Debit authorization code.
 *     amount_bonus?: int|float|numeric-string, // Sender bonus in debit currency.
 *     amount_credit?: int|float|numeric-string, // Credit amount in credit currency.
 *     amount_debit?: int|float|numeric-string, // Debit amount in debit currency.
 *     card_token?: string, // LiqPay card token.
 *     commission_credit?: int|float|numeric-string, // Recipient fee in credit currency.
 *     commission_debit?: int|float|numeric-string, // Sender fee in debit currency.
 *     create_date?: int|string, // Creation date.
 *     currency?: string, // Payment currency.
 *     currency_credit?: string, // Credit currency.
 *     currency_debit?: string, // Debit currency.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     is_3ds?: bool|'true'|'false', // Whether 3-D Secure was used; examples also use string booleans.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     mpi_eci?: int|numeric-string, // 3-D Secure ECI indicator: 5, 6 or 7.
 *     order_id?: string, // Merchant order identifier.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     paytype?: string, // Payment method.
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     rrn_debit?: string, // Debit retrieval reference number.
 *     sender_bonus?: int|float|numeric-string, // Sender bonus in payment currency.
 *     sender_card_bank?: string, // Sender card issuer.
 *     sender_card_country?: int|string, // Card country, numeric ISO 3166-1 code.
 *     sender_card_mask2?: string, // Masked sender card.
 *     sender_card_type?: string, // Sender card network: MC or Visa.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     transaction_id?: int|numeric-string, // LiqPay transaction identifier.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 * }
 *
 * @extends AbstractRequest<SubscriptionCreateResponse>
 */
final class SubscriptionCreateRequest extends AbstractRequest
{
    protected const ACTION = 'subscribe';

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id', 'card', 'card_cvv', 'card_exp_month', 'card_exp_year', 'ip', 'phone', 'subscribe_date_start'];

    public function amount(int|float|string $value): static
    {
        return $this->withParameter('amount', $value);
    }

    public function card(string $value): static
    {
        return $this->withParameter('card', $value);
    }

    public function cardCvv(string $value): static
    {
        return $this->withParameter('card_cvv', $value);
    }

    public function cardExpMonth(string $value): static
    {
        return $this->withParameter('card_exp_month', $value);
    }

    public function cardExpYear(string $value): static
    {
        return $this->withParameter('card_exp_year', $value);
    }

    public function currency(string $value): static
    {
        return $this->withParameter('currency', $value);
    }

    public function description(string $value): static
    {
        return $this->withParameter('description', $value);
    }

    public function ip(string $value): static
    {
        return $this->withParameter('ip', $value);
    }

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function prepare(bool|string|int $value): static
    {
        return $this->withParameter('prepare', $value);
    }

    public function recurringbytoken(bool|string|int $value): static
    {
        return $this->withParameter('recurringbytoken', $value);
    }

    public function isRecurring(bool $value): static
    {
        return $this->withParameter('is_recurring', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
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

    public function customer(string $value): static
    {
        return $this->withParameter('customer', $value);
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
