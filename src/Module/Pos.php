<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Pos
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function receivers(): Request\PosReceiversRequest
    {
        return new Request\PosReceiversRequest($this->executor, $this->version);
    }

    public function waiters(): Request\PosWaitersRequest
    {
        return new Request\PosWaitersRequest($this->executor, $this->version);
    }

    public function tables(): Request\PosTablesRequest
    {
        return new Request\PosTablesRequest($this->executor, $this->version);
    }

    public function companyStatus(): Request\PosCompanyStatusRequest
    {
        return new Request\PosCompanyStatusRequest($this->executor, $this->version);
    }

    public function receiversStatus(): Request\PosReceiversStatusRequest
    {
        return new Request\PosReceiversStatusRequest($this->executor, $this->version);
    }

    public function waitersStatus(): Request\PosWaitersStatusRequest
    {
        return new Request\PosWaitersStatusRequest($this->executor, $this->version);
    }

    public function tablesStatus(): Request\PosTablesStatusRequest
    {
        return new Request\PosTablesStatusRequest($this->executor, $this->version);
    }

    public function allCompaniesStatus(): Request\PosAllCompaniesStatusRequest
    {
        return new Request\PosAllCompaniesStatusRequest($this->executor, $this->version);
    }

    public function bills(): Request\PosBillsRequest
    {
        return new Request\PosBillsRequest($this->executor, $this->version);
    }

    public function splitBills(): Request\PosSplitBillsRequest
    {
        return new Request\PosSplitBillsRequest($this->executor, $this->version);
    }

    public function refundBill(): Request\PosRefundBillRequest
    {
        return new Request\PosRefundBillRequest($this->executor, $this->version);
    }
}
