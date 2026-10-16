<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay;

use InvalidArgumentException;

final readonly class Configuration
{
    /** @param array<string, mixed> $httpOptions Options for the built-in Guzzle client only. */
    public function __construct(
        public ApiVersion $apiVersion = ApiVersion::V7,
        public string $apiBaseUri = 'https://www.liqpay.ua/api/',
        public string $checkoutUrl = 'https://www.liqpay.ua/api/3/checkout',
        public string $publicBaseUri = 'https://api.privatbank.ua/p24api/',
        public string $posDataUrl = 'https://tradingpoints.privatbank.ua/trading-points/horeca/api/pos/data',
        public string $posCallbackUrl = 'https://qr.liqpay.ua/api/extcallback',
        public string $posRequestUrl = 'https://qr.liqpay.ua/api/extapi/request',
        public array $httpOptions = [],
        public string $userAgent = 'andriichuk/liqpay-php-sdk',
    ) {
        foreach ([$apiBaseUri, $checkoutUrl, $publicBaseUri, $posDataUrl, $posCallbackUrl, $posRequestUrl] as $url) {
            $parts = parse_url($url);
            if (! is_array($parts) || ($parts['scheme'] ?? '') !== 'https' || empty($parts['host'])
                || isset($parts['user']) || isset($parts['pass'])
                || isset($parts['query']) || isset($parts['fragment'])) {
                throw new InvalidArgumentException('Endpoint URLs must be absolute HTTPS URLs without credentials, queries or fragments.');
            }
        }
        if (str_contains($userAgent, "\r") || str_contains($userAgent, "\n")) {
            throw new InvalidArgumentException('User agent must not contain line breaks.');
        }
    }
}
