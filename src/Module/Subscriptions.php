<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Subscriptions
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function create(): Request\SubscriptionCreateRequest
    {
        return new Request\SubscriptionCreateRequest($this->executor, $this->version);
    }

    public function cancel(): Request\SubscriptionCancelRequest
    {
        return new Request\SubscriptionCancelRequest($this->executor, $this->version);
    }

    public function update(): Request\SubscriptionUpdateRequest
    {
        return new Request\SubscriptionUpdateRequest($this->executor, $this->version);
    }
}
