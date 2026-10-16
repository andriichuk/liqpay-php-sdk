<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Information
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function status(): Request\StatusRequest
    {
        return new Request\StatusRequest($this->executor, $this->version);
    }

    public function data(): Request\PaymentDataRequest
    {
        return new Request\PaymentDataRequest($this->executor, $this->version);
    }

    public function receipt(): Request\ReceiptRequest
    {
        return new Request\ReceiptRequest($this->executor, $this->version);
    }

    public function reports(): Request\ReportsRequest
    {
        return new Request\ReportsRequest($this->executor, $this->version);
    }

    public function compensation(): Request\CompensationRequest
    {
        return new Request\CompensationRequest($this->executor, $this->version);
    }

    public function register(): Request\RegisterRequest
    {
        return new Request\RegisterRequest($this->executor, $this->version);
    }

    public function compensationFile(): Request\CompensationFileRequest
    {
        return new Request\CompensationFileRequest($this->executor, $this->version);
    }

    public function compensationFileStatus(): Request\CompensationFileStatusRequest
    {
        return new Request\CompensationFileStatusRequest($this->executor, $this->version);
    }
}
