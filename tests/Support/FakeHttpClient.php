<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests\Support;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class FakeHttpClient implements ClientInterface
{
    /** @var list<RequestInterface> */
    public array $requests = [];

    public function __construct(private readonly ResponseInterface|\Throwable $response) {}

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;
        if ($this->response instanceof \Throwable) {
            throw $this->response;
        }

        return $this->response;
    }
}
