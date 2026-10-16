<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Partnerships
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function createMerchant(): Request\MerchantCreateRequest
    {
        return new Request\MerchantCreateRequest($this->executor, $this->version);
    }

    public function registerMerchant(): Request\MerchantRegisterRequest
    {
        return new Request\MerchantRegisterRequest($this->executor, $this->version);
    }

    public function editMerchant(): Request\MerchantEditRequest
    {
        return new Request\MerchantEditRequest($this->executor, $this->version);
    }

    public function merchantInfo(): Request\MerchantInfoRequest
    {
        return new Request\MerchantInfoRequest($this->executor, $this->version);
    }

    public function userInfo(): Request\UserInfoRequest
    {
        return new Request\UserInfoRequest($this->executor, $this->version);
    }

    public function mccCodes(): Request\MccCodesRequest
    {
        return new Request\MccCodesRequest($this->executor, $this->version);
    }

    public function mccDocuments(): Request\MccDocumentsRequest
    {
        return new Request\MccDocumentsRequest($this->executor, $this->version);
    }
}
