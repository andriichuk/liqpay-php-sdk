<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/public/exchange
 *
 * @phpstan-type ExchangeRate array{
 *     ccy?: string, // Currency code.
 *     base_ccy?: string, // Domestic currency code.
 *     buy?: numeric-string, // Purchase exchange rate.
 *     sale?: numeric-string, // Sale exchange rate.
 * }
 * @phpstan-type ExchangeRatesResponse list<ExchangeRate>
 *
 * @extends AbstractRequest<ExchangeRatesResponse>
 */
final class ExchangeRatesRequest extends AbstractRequest
{
    protected const ACTION = '';

    protected const ENDPOINT = 'publicExchange';

    protected const DEFAULTS = ['coursid' => 5, 'exchange' => ''];

    public function coursid(int|float|string $value): static
    {
        return $this->withParameter('coursid', $value);
    }
}
