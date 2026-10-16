<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Transfers
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function toCard(): Request\TransferToCardRequest
    {
        return new Request\TransferToCardRequest($this->executor, $this->version);
    }

    public function toAccount(): Request\TransferToAccountRequest
    {
        return new Request\TransferToAccountRequest($this->executor, $this->version);
    }
}
