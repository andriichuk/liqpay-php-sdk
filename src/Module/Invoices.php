<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class Invoices
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function create(): Request\InvoiceCreateRequest
    {
        return new Request\InvoiceCreateRequest($this->executor, $this->version);
    }

    public function cancel(): Request\InvoiceCancelRequest
    {
        return new Request\InvoiceCancelRequest($this->executor, $this->version);
    }

    public function units(): Request\InvoiceUnitsRequest
    {
        return new Request\InvoiceUnitsRequest($this->executor, $this->version);
    }
}
