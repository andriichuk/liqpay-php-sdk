<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/information/register
 *
 * @phpstan-type RegisterJson array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     data?: list<RegisterRecord>, // Report records.
 * }
 * @phpstan-type RegisterRecord array{
 *     action?: string, // Operation type.
 *     authcode_debit?: string, // Debit authorization code.
 *     bonus_type?: string|null, // Bonus category: bonusplus, discount_club, personal or promo.
 *     channel?: string, // Payment channel: checkout, checkoutjs or api.
 *     create_date?: int|string, // Creation date.
 *     customer?: string|null, // Merchant customer identifier.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     id?: int|numeric-string, // Identifier.
 *     ip?: string, // Sender IP address.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     order_id?: string, // Merchant order identifier.
 *     paytype?: string, // Payment method.
 *     sender_card?: string, // Sender card.
 *     sender_card_bank?: string, // Sender card issuer.
 *     sender_card_country?: int|string, // Card country, numeric ISO 3166-1 code.
 *     sender_card_product_type?: string, // Card product category.
 *     sender_card_type?: string, // Sender card network: MC or Visa.
 *     sender_email?: string|null, // Payer email.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     trans_amount?: int|float|numeric-string, // Transaction amount.
 *     trans_bonus?: int|float|numeric-string, // Transaction bonus.
 *     trans_currency?: string, // Transaction currency.
 *     trans_fee_credit?: int|float|numeric-string, // Credit transaction fee.
 *     trans_fee_debit?: int|float|numeric-string, // Debit transaction fee.
 *     trans_total?: int|float|numeric-string, // Company settlement amount.
 *     trans_type?: string, // Transaction type: reverse, hold_compl, purchase or refund.
 * }
 * @phpstan-type RegisterResponse RegisterJson|string
 *
 * @extends AbstractRequest<RegisterResponse>
 */
final class RegisterRequest extends AbstractRequest
{
    protected const ACTION = 'register';

    protected const REQUIRED = ['format', 'date'];

    public function format(string $value): static
    {
        return $this->withParameter('format', $value);
    }

    public function date(string $value): static
    {
        return $this->withParameter('date', $value);
    }
}
