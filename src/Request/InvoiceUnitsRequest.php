<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice
 *
 * @phpstan-import-type ApiError from \Andriichuk\LiqPay\LiqPay
 *
 * @phpstan-type InvoiceUnit array{
 *     id?: int|numeric-string, // Identifier.
 *     full_name_en?: string, // Full unit name in English.
 *     short_name_en?: string, // Short unit name in English.
 *     full_name_uk?: string, // Full unit name in Ukrainian.
 *     short_name_uk?: string, // Short unit name in Ukrainian.
 *     full_name?: string, // Full unit name in the selected language.
 *     short_name?: string, // Short unit name in the selected language.
 * }
 * @phpstan-type InvoiceUnitsResponse list<InvoiceUnit>|ApiError
 *
 * @extends AbstractRequest<InvoiceUnitsResponse>
 */
final class InvoiceUnitsRequest extends AbstractRequest
{
    protected const ACTION = 'invoice_units_get_list';

    public function hideNameLang(bool|string|int $value): static
    {
        return $this->withParameter('hide_name_lang', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }
}
