<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Tokens
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function create(): Request\TokenCreateRequest
    {
        return new Request\TokenCreateRequest($this->executor, $this->version);
    }

    public function createUnique(): Request\TokenCreateUniqueRequest
    {
        return new Request\TokenCreateUniqueRequest($this->executor, $this->version);
    }

    public function update(): Request\TokenUpdateRequest
    {
        return new Request\TokenUpdateRequest($this->executor, $this->version);
    }
}
