<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Exception;

final class HttpException extends LiqPayException
{
    public function __construct(public readonly int $statusCode, public readonly string $responseBody)
    {
        parent::__construct('LiqPay HTTP request failed with status '.$statusCode.'.', $statusCode);
    }
}
