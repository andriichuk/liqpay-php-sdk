<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Confirmations
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function threeDs(): Request\Confirm3dsRequest
    {
        return new Request\Confirm3dsRequest($this->executor, $this->version);
    }

    public function cvv(): Request\ConfirmCvvRequest
    {
        return new Request\ConfirmCvvRequest($this->executor, $this->version);
    }

    public function otp(): Request\ConfirmOtpRequest
    {
        return new Request\ConfirmOtpRequest($this->executor, $this->version);
    }
}
