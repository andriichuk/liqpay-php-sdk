<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/cash
 *
 * @phpstan-type CashResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, success, cash_wait.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     acq_id?: int|numeric-string, // Acquirer identifier.
 *     action?: string, // Operation type.
 *     agent_commission?: int|float|numeric-string, // Agent fee in payment currency.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     amount_bonus?: int|float|numeric-string, // Sender bonus in debit currency.
 *     amount_credit?: int|float|numeric-string, // Credit amount in credit currency.
 *     amount_debit?: int|float|numeric-string, // Debit amount in debit currency.
 *     commission_credit?: int|float|numeric-string, // Recipient fee in credit currency.
 *     commission_debit?: int|float|numeric-string, // Sender fee in debit currency.
 *     confirm_phone?: string, // Payer phone receiving the confirmation OTP.
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
 *     order_id?: string, // Merchant order identifier.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     paytype?: string, // Payment method.
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     sender_bonus?: int|float|numeric-string, // Sender bonus in payment currency.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     transaction_id?: int|numeric-string, // LiqPay transaction identifier.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 * }
 *
 * @extends AbstractRequest<CashResponse>
 */
final class CashRequest extends AbstractRequest
{
    protected const ACTION = 'paycash';

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id', 'ip', 'phone'];

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

    public function expiredDate(string $value): static
    {
        return $this->withParameter('expired_date', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function prepare(bool|string|int $value): static
    {
        return $this->withParameter('prepare', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    /** @param array<array-key, mixed> $value */
    public function splitRules(array|string $value): static
    {
        $value = is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : $value;

        return $this->withParameter('split_rules', $value);
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
