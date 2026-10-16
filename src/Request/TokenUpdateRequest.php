<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/tokens
 *
 * @phpstan-type TokenUpdateResponse array{
 *     result?: string, // Request result: ok, error, success.
 *     status?: string, // Tokenization operation state.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     card_token?: string, // LiqPay card token.
 *     card_token_info?: UpdatedNetworkToken, // Mastercard or Visa token information.
 * }
 * @phpstan-type UpdatedNetworkToken array{
 *     tokenRef?: string, // Payment-network token reference.
 *     tokenSuffix?: string, // Last four token digits.
 *     tokenExpDate?: string, // Token expiration date.
 *     status?: string, // Token state: INACTIVE, ACTIVE, SUSPENDED or DELETED.
 *     decision?: string, // Mastercard tokenization decision.
 * }
 *
 * @extends AbstractRequest<TokenUpdateResponse>
 */
final class TokenUpdateRequest extends AbstractRequest
{
    protected const ACTION = 'token_update';

    protected const REQUIRED = ['card_token', 'card_token_action'];

    public function cardToken(string $value): static
    {
        return $this->withParameter('card_token', $value);
    }

    public function cardTokenAction(string $value): static
    {
        return $this->withParameter('card_token_action', $value);
    }
}
