<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/shop_create
 *
 * @phpstan-type MccCode array{
 *     id?: int|numeric-string, // Identifier.
 *     mcc_code?: int|numeric-string|''|null, // MCC; category entries may have no code.
 *     name?: string, // Category or MCC name.
 *     parent_id?: int|numeric-string|null, // Parent category identifier.
 * }
 * @phpstan-type MccCodesResponse array{
 *     result?: string, // Request result.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     mcc_codes?: list<MccCode>, // Merchant category entries.
 * }
 *
 * @extends AbstractRequest<MccCodesResponse>
 */
final class MccCodesRequest extends AbstractRequest
{
    protected const ACTION = 'agent_info_mcc_codes';

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }
}
