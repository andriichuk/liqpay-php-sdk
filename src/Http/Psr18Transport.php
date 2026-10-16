<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Http;

use Andriichuk\LiqPay\Contract\TransportInterface;
use Andriichuk\LiqPay\Exception\HttpException;
use Andriichuk\LiqPay\Exception\InvalidResponseException;
use Andriichuk\LiqPay\Exception\TransportException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

final readonly class Psr18Transport implements TransportInterface
{
    public function __construct(
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private StreamFactoryInterface $streamFactory,
        private string $userAgent,
    ) {}

    public function post(string $url, array $fields, bool $jsonEnvelope = false, bool $rawResponse = false): mixed
    {
        $body = $jsonEnvelope ? json_encode($fields, JSON_THROW_ON_ERROR) : http_build_query($fields, '', '&', PHP_QUERY_RFC3986);
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', $jsonEnvelope ? 'application/json' : 'application/x-www-form-urlencoded')
            ->withBody($this->streamFactory->createStream($body));

        return $this->send($request, $rawResponse);
    }

    public function get(string $url, array $query = []): mixed
    {
        if ($query !== []) {
            $url .= '?'.http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        }

        return $this->send($this->requestFactory->createRequest('GET', $url));
    }

    private function send(RequestInterface $request, bool $rawResponse = false): mixed
    {
        $request = $request->withHeader('Accept', $rawResponse ? '*/*' : 'application/json')
            ->withHeader('User-Agent', $this->userAgent);
        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new TransportException('Unable to reach the API.', previous: $e);
        }
        $body = (string) $response->getBody();
        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            throw new HttpException($response->getStatusCode(), $body);
        }
        if ($rawResponse && ! str_contains(strtolower($response->getHeaderLine('Content-Type')), 'json')) {
            return $body;
        }
        try {
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        } catch (JsonException $e) {
            throw new InvalidResponseException('The API returned invalid JSON.', previous: $e);
        }
    }
}
