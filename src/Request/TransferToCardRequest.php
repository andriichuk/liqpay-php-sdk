<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/transferring_to_card
 *
 * @phpstan-type TransferToCardResponse array{
 *     result?: string, // Request result: ok, error.
 *     status?: string, // Status: error, failure, success.
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
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     redirect_to?: string, // URL for customer 3-D Secure verification.
 *     sender_bonus?: int|float|numeric-string, // Sender bonus in payment currency.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     transaction_id?: int|numeric-string, // LiqPay transaction identifier.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 * }
 *
 * @extends AbstractRequest<TransferToCardResponse>
 */
final class TransferToCardRequest extends AbstractRequest
{
    protected const ACTION = 'p2pcredit';

    protected const REQUIRED_ALTERNATIVES = [['receiver_card'], ['receiver_card_token'], ['receiver_account', 'receiver_mfo', 'receiver_okpo', 'receiver_company']];

    protected const REQUIRED = ['amount', 'currency', 'description', 'order_id', 'ip'];

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

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }

    public function serverUrl(string $value): static
    {
        return $this->withParameter('server_url', $value);
    }

    public function taxed(string $value): static
    {
        return $this->withParameter('taxed', $value);
    }

    public function receiverAccount(string $value): static
    {
        return $this->withParameter('receiver_account', $value);
    }

    public function receiverMfo(string $value): static
    {
        return $this->withParameter('receiver_mfo', $value);
    }

    public function receiverOkpo(string $value): static
    {
        return $this->withParameter('receiver_okpo', $value);
    }

    public function receiverCompany(string $value): static
    {
        return $this->withParameter('receiver_company', $value);
    }

    public function receiverCard(string $value): static
    {
        return $this->withParameter('receiver_card', $value);
    }

    public function receiverCardToken(string $value): static
    {
        return $this->withParameter('receiver_card_token', $value);
    }

    public function senderFirstName(string $value): static
    {
        return $this->withParameter('sender_first_name', $value);
    }

    public function senderLastName(string $value): static
    {
        return $this->withParameter('sender_last_name', $value);
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

    public function senderPostalCode(string $value): static
    {
        return $this->withParameter('sender_postal_code', $value);
    }

    public function receiverFirstName(string $value): static
    {
        return $this->withParameter('receiver_first_name', $value);
    }

    public function receiverLastName(string $value): static
    {
        return $this->withParameter('receiver_last_name', $value);
    }

    public function customer(string $value): static
    {
        return $this->withParameter('customer', $value);
    }

    public function info(string $value): static
    {
        return $this->withParameter('info', $value);
    }
}
