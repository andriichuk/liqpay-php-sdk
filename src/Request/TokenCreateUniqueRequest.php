<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/tokens
 *
 * @phpstan-import-type NetworkToken from \Andriichuk\LiqPay\Request\TokenCreateRequest
 *
 * @phpstan-type TokenCreateUniqueResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Tokenization operation state.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     card_token?: string, // LiqPay card token.
 *     card_token_info?: NetworkToken, // Mastercard or Visa token information.
 * }
 *
 * @extends AbstractRequest<TokenCreateUniqueResponse>
 */
final class TokenCreateUniqueRequest extends AbstractRequest
{
    protected const ACTION = 'token_create_unique';

    protected const REQUIRED_ALTERNATIVES = [['pushAccountReceipt'], ['pushdata', 'customer'], ['card', 'card_cvv', 'card_exp_month', 'card_exp_year']];

    protected const REQUIRED = ['is_debit', 'is_credit'];

    public function isDebit(bool $value): static
    {
        return $this->withParameter('is_debit', $value);
    }

    public function isCredit(bool $value): static
    {
        return $this->withParameter('is_credit', $value);
    }

    public function pushAccountReceipt(string $value): static
    {
        return $this->withParameter('pushAccountReceipt', $value);
    }

    public function pushdata(string $value): static
    {
        return $this->withParameter('pushdata', $value);
    }

    public function customer(string $value): static
    {
        return $this->withParameter('customer', $value);
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
}
