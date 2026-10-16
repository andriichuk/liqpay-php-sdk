<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Contract;

use Andriichuk\LiqPay\ApiVersion;

/**
 * @see https://www.liqpay.ua/en/doc/api/internet_acquiring/checkout
 *
 * @phpstan-type CheckoutPayload array{
 *     url: string, // Company or payment URL.
 *     data: string, // Base64-encoded JSON payment parameters.
 *     signature: string, // Base64-encoded binary SHA3-256 signature (SHA-1 for v3).
 * }
 */
interface RequestExecutorInterface
{
    /** @param array<string, mixed> $parameters */
    public function execute(string $endpoint, array $parameters, ApiVersion $version): mixed;

    /** @param array<string, mixed> $parameters
     * @return CheckoutPayload
     */
    public function checkout(array $parameters, ApiVersion $version): array;
}
