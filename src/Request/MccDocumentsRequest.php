<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

/**
 * @see https://www.liqpay.ua/en/doc/api/partnership/shop_create
 *
 * @phpstan-type MccDocument array{
 *     doc_id?: int|numeric-string, // Document identifier.
 *     doc_type?: string, // Document requirement: required, allof or optional.
 *     name?: string, // Document name.
 *     alt_docs?: list<int|numeric-string>, // Identifiers of documents that can replace this document.
 *     description?: string, // Document description.
 * }
 * @phpstan-type MccDocumentsResponse array{
 *     result?: string, // Request result.
 *     status?: string, // Operation or payment status; values depend on operation.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     expected_docs?: list<MccDocument>, // Documents required for the MCC.
 * }
 *
 * @extends AbstractRequest<MccDocumentsResponse>
 */
final class MccDocumentsRequest extends AbstractRequest
{
    protected const ACTION = 'agent_info_mcc_docs';

    protected const REQUIRED = ['mcc_code'];

    public function mccCode(int|string $value): static
    {
        return $this->withParameter('mcc_code', $value);
    }

    public function language(string $value): static
    {
        return $this->withParameter('language', $value);
    }
}
