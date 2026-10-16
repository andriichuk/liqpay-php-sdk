<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/p2pdebit
 *
 * @phpstan-type TransferToAccountResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Status: error, failure, reversed, subscribed, success, unsubscribed, captcha_verify, cvv_verify, ivr_verify, otp_verify, password_verify, phone_verify, pin_verify, pin, senderapp_verify, wait_qr, QR, wait_sender, cash_wait, hold_wait, invoice_wait, prepared, processing, wait_accept, wait_card, wait_compensation, wait_lc, wait_reserve, wait_secure.
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
 *     card_token?: string, // LiqPay card token.
 *     commission_credit?: int|float|numeric-string, // Recipient fee in credit currency.
 *     commission_debit?: int|float|numeric-string, // Sender fee in debit currency.
 *     completion_date?: int|string, // Funds capture date.
 *     create_date?: int|string, // Creation date.
 *     currency?: string, // Payment currency.
 *     currency_credit?: string, // Credit currency.
 *     currency_debit?: string, // Debit currency.
 *     customer?: string|null, // Merchant customer identifier.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     info?: string, // Additional payment information.
 *     ip?: string, // Sender IP address.
 *     is_3ds?: bool|'true'|'false', // Whether 3-D Secure was used; examples also use string booleans.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     mpi_eci?: int|numeric-string, // 3-D Secure ECI indicator: 5, 6 or 7.
 *     order_id?: string, // Merchant order identifier.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     paytype?: string, // Payment method.
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     redirect_to?: string, // URL for customer 3-D Secure verification.
 *     refund_date_last?: int|string, // Most recent refund date.
 *     rrn_credit?: string, // Credit retrieval reference number.
 *     rrn_debit?: string, // Debit retrieval reference number.
 *     sender_bonus?: int|float|numeric-string, // Sender bonus in payment currency.
 *     sender_card_bank?: string, // Sender card issuer.
 *     sender_card_country?: int|string, // Card country, numeric ISO 3166-1 code.
 *     sender_card_mask2?: string, // Masked sender card.
 *     sender_iban?: string, // Sender IBAN.
 *     sender_card_type?: string, // Sender card network: MC or Visa.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     wait_reserve_status?: string, // Whether the payment is reserved for a refund.
 *     token?: string, // Payment token.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 *     err_erc?: string, // Additional error code.
 *     product_category?: string, // Product category.
 *     product_description?: string, // Product description.
 *     product_name?: string, // Product name.
 *     product_url?: string, // Product page URL.
 *     refund_amount?: int|float|numeric-string, // Refunded amount.
 *     verifycode?: string, // Verification code.
 * }
 *
 * @extends AbstractRequest<TransferToAccountResponse>
 */
final class TransferToAccountRequest extends AbstractRequest
{
    protected const ACTION = 'p2pdebit';

    protected const REQUIRED_ALTERNATIVES = [['card'], ['card_token']];

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id', 'phone'];

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

    public function cardToken(string $value): static
    {
        return $this->withParameter('card_token', $value);
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

    public function resultUrl(string $value): static
    {
        return $this->withParameter('result_url', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    public function sandbox(bool|string|int $value): static
    {
        return $this->withParameter('sandbox', $value);
    }

    public function senderFirstName(string $value): static
    {
        return $this->withParameter('sender_first_name', $value);
    }

    public function senderLastName(string $value): static
    {
        return $this->withParameter('sender_last_name', $value);
    }

    public function senderEmail(string $value): static
    {
        return $this->withParameter('sender_email', $value);
    }

    public function senderCountryCode(string $value): static
    {
        return $this->withParameter('sender_country_code', $value);
    }

    public function senderCity(string $value): static
    {
        return $this->withParameter('sender_city', $value);
    }

    public function senderAddress(string $value): static
    {
        return $this->withParameter('sender_address', $value);
    }

    public function senderState(string $value): static
    {
        return $this->withParameter('sender_state', $value);
    }

    public function senderShippingState(string $value): static
    {
        return $this->withParameter('sender_shipping_state', $value);
    }

    public function senderPostalCode(string $value): static
    {
        return $this->withParameter('sender_postal_code', $value);
    }

    public function mpiEci(int|float|string $value): static
    {
        return $this->withParameter('mpi_eci', $value);
    }

    public function mpiCres(string $value): static
    {
        return $this->withParameter('mpi_cres', $value);
    }
}
