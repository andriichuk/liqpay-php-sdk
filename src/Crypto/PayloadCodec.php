<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Crypto;

use InvalidArgumentException;
use JsonException;

final class PayloadCodec
{
    /** @param array<string, mixed> $parameters */
    public function encode(array $parameters): string
    {
        try {
            return base64_encode(json_encode($parameters, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Request parameters must be JSON encodable.', previous: $e);
        }
    }

    /** @return array<string, mixed> */
    public function decode(string $data): array
    {
        $json = base64_decode($data, true);
        if ($json === false) {
            throw new InvalidArgumentException('Payload must be valid base64.');
        }
        try {
            $payload = json_decode($json, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Payload must contain valid JSON.', previous: $e);
        }
        if (! is_array($payload) || ! str_starts_with(ltrim($json), '{')) {
            throw new InvalidArgumentException('Payload must contain a JSON object.');
        }

        /** @var array<string, mixed> $payload */
        return $payload;
    }
}
