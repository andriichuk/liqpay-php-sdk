<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Contract;

interface TransportInterface
{
    /** @param array<string, string> $fields */
    public function post(string $url, array $fields, bool $jsonEnvelope = false, bool $rawResponse = false): mixed;

    /** @param array<string, scalar> $query */
    public function get(string $url, array $query = []): mixed;
}
