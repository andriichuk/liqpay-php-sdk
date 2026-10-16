<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests;

use Andriichuk\LiqPay\Configuration;
use Andriichuk\LiqPay\LiqPay;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ConfigurationTest extends TestCase
{
    public static function invalidKeys(): iterable
    {
        yield ['', 'private'];
        yield ['  ', 'private'];
        yield ['public', ''];
        yield ['public', '  '];
    }

    #[DataProvider('invalidKeys')]
    public function test_empty_credentials_are_rejected(string $public, string $private): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new LiqPay($public, $private);
    }

    public static function invalidUrls(): iterable
    {
        foreach (['http://example.test/', '//example.test/', 'https://user:pass@example.test/', 'https://user@example.test/', 'https://example.test/?q=x', 'https://example.test/#fragment', 'not a URL'] as $url) {
            yield [$url];
        }
    }

    #[DataProvider('invalidUrls')]
    public function test_invalid_api_endpoints_are_rejected(string $url): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Configuration(apiBaseUri: $url);
    }

    public function test_invalid_user_agent_is_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Configuration(userAgent: "app\r\nBad: header");
    }
}
