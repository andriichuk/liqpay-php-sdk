<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Module;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Request;

final readonly class PublicApi
{
    public function __construct(private RequestExecutorInterface $executor, private ApiVersion $version) {}

    public function exchangeRates(): Request\ExchangeRatesRequest
    {
        return new Request\ExchangeRatesRequest($this->executor, $this->version);
    }

    public function exchangeArchive(): Request\ExchangeArchiveRequest
    {
        return new Request\ExchangeArchiveRequest($this->executor, $this->version);
    }
}
