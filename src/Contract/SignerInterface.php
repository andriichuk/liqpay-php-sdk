<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Contract;

use Andriichuk\LiqPay\ApiVersion;

interface SignerInterface
{
    public function sign(string $data, ApiVersion $version): string;

    public function verify(string $data, string $signature, ApiVersion $version): bool;
}
