<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Crypto;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\SignerInterface;
use InvalidArgumentException;

final readonly class Signer implements SignerInterface
{
    public function __construct(#[\SensitiveParameter] private string $privateKey)
    {
        if (trim($privateKey) === '') {
            throw new InvalidArgumentException('Private key must not be empty.');
        }
    }

    public function sign(string $data, ApiVersion $version): string
    {
        return base64_encode(hash($version->hashAlgorithm(), $this->privateKey.$data.$this->privateKey, true));
    }

    public function verify(string $data, string $signature, ApiVersion $version): bool
    {
        return hash_equals($this->sign($data, $version), $signature);
    }

    /** @return array<string, string> */
    public function __debugInfo(): array
    {
        return ['privateKey' => '[redacted]'];
    }
}
