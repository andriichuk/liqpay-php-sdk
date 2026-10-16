<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay;

use InvalidArgumentException;

enum ApiVersion: int
{
    case V3 = 3;
    case V7 = 7;

    public static function resolve(self|int|string $version): self
    {
        if ($version instanceof self) {
            return $version;
        }

        return match ($version) {
            3, '3' => self::V3,
            7, '7' => self::V7,
            default => throw new InvalidArgumentException('Supported API versions are 3 and 7.'),
        };
    }

    public function hashAlgorithm(): string
    {
        return $this === self::V7 ? 'sha3-256' : 'sha1';
    }
}
