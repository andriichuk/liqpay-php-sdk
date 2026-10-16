<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/public/archive
 *
 * @phpstan-type ArchivedExchangeRate array{
 *     baseCurrency?: string, // Base currency code.
 *     currency?: string, // Quoted currency code.
 *     saleRateNB?: int|float|numeric-string, // National Bank sale rate.
 *     purchaseRateNB?: int|float|numeric-string, // National Bank purchase rate.
 *     saleRate?: int|float|numeric-string, // PrivatBank sale rate, when available.
 *     purchaseRate?: int|float|numeric-string, // PrivatBank purchase rate, when available.
 * }
 * @phpstan-type ExchangeArchiveResponse array{
 *     date?: string, // Exchange-rate date, DD.MM.YYYY.
 *     bank?: string, // Bank name.
 *     baseCurrency?: int|numeric-string, // Base currency code.
 *     baseCurrencyLit?: string, // Base currency alphabetic code.
 *     exchangeRate?: list<ArchivedExchangeRate>, // Exchange-rate records.
 * }
 *
 * @extends AbstractRequest<ExchangeArchiveResponse>
 */
final class ExchangeArchiveRequest extends AbstractRequest
{
    protected const ACTION = '';

    protected const ENDPOINT = 'publicArchive';

    protected const REQUIRED = ['date'];

    public function date(string $value): static
    {
        return $this->withParameter('date', $value);
    }
}
