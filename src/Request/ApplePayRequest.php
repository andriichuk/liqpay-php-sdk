<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/apay
 *
 * @phpstan-type ApplePayResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, reversed, success, cvv_verify, otp_verify, wait_accept, wait_secure.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     acq_id?: int|numeric-string, // Acquirer identifier.
 *     action?: string, // Operation type.
 *     agent_commission?: int|float|numeric-string, // Agent fee in payment currency.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     amount_bonus?: int|float|numeric-string, // Sender bonus in debit currency.
 *     amount_credit?: int|float|numeric-string, // Credit amount in credit currency.
 *     amount_debit?: int|float|numeric-string, // Debit amount in debit currency.
 *     authcode_credit?: string, // Credit authorization code.
 *     authcode_debit?: string, // Debit authorization code.
 *     bonus_procent?: int|float|numeric-string, // Discount percentage.
 *     bonus_type?: string|null, // Bonus category: bonusplus, discount_club, personal or promo.
 *     card_token?: string, // LiqPay card token.
 *     commission_credit?: int|float|numeric-string, // Recipient fee in credit currency.
 *     commission_debit?: int|float|numeric-string, // Sender fee in debit currency.
 *     create_date?: int|string, // Creation date.
 *     currency?: string, // Payment currency.
 *     currency_credit?: string, // Credit currency.
 *     currency_debit?: string, // Debit currency.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     ip?: string, // Sender IP address.
 *     is_3ds?: bool|'true'|'false', // Whether 3-D Secure was used; examples also use string booleans.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     mpi_eci?: int|numeric-string, // 3-D Secure ECI indicator: 5, 6 or 7.
 *     mpi_cres?: string, // Issuer ACS authentication result.
 *     order_id?: string, // Merchant order identifier.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     paytype?: string, // Payment method.
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     rrn_credit?: string, // Credit retrieval reference number.
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
 *     language?: string, // Response language: uk or en.
 *     confirm_phone?: string, // Payer phone receiving the confirmation OTP.
 * }
 *
 * @extends AbstractRequest<ApplePayResponse>
 */
final class ApplePayRequest extends AbstractRequest
{
    protected const ACTION = 'pay';

    protected const REQUIRED_ALTERNATIVES = [['applepay_token'], ['card', 'tavv', 'card_exp_month', 'card_exp_year']];

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id'];

    protected const DEFAULTS = ['paytype' => 'apay'];

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

    public function phone(string $value): static
    {
        return $this->withParameter('phone', $value);
    }

    public function paytype(string $value): static
    {
        return $this->withParameter('paytype', $value);
    }

    public function tavv(string $value): static
    {
        return $this->withParameter('tavv', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function resultUrl(string $value): static
    {
        return $this->withParameter('result_url', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    public function card(string $value): static
    {
        return $this->withParameter('card', $value);
    }

    public function cardExpMonth(string $value): static
    {
        return $this->withParameter('card_exp_month', $value);
    }

    public function cardExpYear(string $value): static
    {
        return $this->withParameter('card_exp_year', $value);
    }

    public function eci(string $value): static
    {
        return $this->withParameter('eci', $value);
    }

    public function cavv(string $value): static
    {
        return $this->withParameter('cavv', $value);
    }

    public function tdsv(string $value): static
    {
        return $this->withParameter('tdsv', $value);
    }

    public function dsTransID(string $value): static
    {
        return $this->withParameter('dsTransID', $value);
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

    /** @param array<array-key, mixed> $value */
    public function splitRules(array|string $value): static
    {
        $value = is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value;

        return $this->withParameter('split_rules', $value);
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

    public function applepayToken(string $value): static
    {
        return $this->withParameter('applepay_token', $value);
    }

    public function splitTicketsOnly(bool $value): static
    {
        return $this->withParameter('split_tickets_only', $value);
    }

    public function hold(): static
    {
        $copy = clone $this;
        $copy->parameters['action'] = 'hold';

        return $copy;
    }
}
