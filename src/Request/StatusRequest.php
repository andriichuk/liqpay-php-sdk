<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/status_payment
 *
 * @phpstan-type StatusResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, reversed, subscribed, success, unsubscribed, captcha_verify, cvv_verify, ivr_verify, otp_verify, password_verify, phone_verify, pin_verify, pin, senderapp_verify, wait_qr, QR, p24_verify, mp_verify, cash_wait, hold_wait, invoice_wait, prepared, processing, wait_accept, wait_card, wait_compensation, wait_lc, wait_reserve, wait_secure, try_again.
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
 *     confirm_phone?: string, // Payer phone receiving the confirmation OTP.
 *     create_date?: int|string, // Creation date.
 *     currency?: string, // Payment currency.
 *     currency_credit?: string, // Credit currency.
 *     currency_debit?: string, // Debit currency.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     info?: string, // Additional payment information.
 *     ip?: string, // Sender IP address.
 *     is_3ds?: bool|'true'|'false', // Whether 3-D Secure was used; examples also use string booleans.
 *     language?: string, // Response language: uk or en.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     moment_part?: string, // Installment payment information.
 *     mpi_eci?: int|numeric-string, // 3-D Secure ECI indicator: 5, 6 or 7.
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
 *     sender_iban?: string, // Sender IBAN.
 *     sender_card_type?: string, // Sender card network: MC or Visa.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     wait_reserve_status?: string, // Whether the payment is reserved for a refund.
 *     transaction_id?: int|numeric-string, // LiqPay transaction identifier.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 * }
 *
 * @extends AbstractRequest<StatusResponse>
 */
final class StatusRequest extends AbstractRequest
{
    protected const ACTION = 'status';

    protected const REQUIRED = ['order_id'];

    public function orderId(string $value): static
    {
        return $this->withParameter('order_id', $value);
    }
}
