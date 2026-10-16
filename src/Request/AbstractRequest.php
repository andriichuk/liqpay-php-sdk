<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use InvalidArgumentException;

/**
 * @template-covariant TResponse
 */
abstract class AbstractRequest
{
    /** @var string */
    protected const ACTION = '';

    /** @var string */
    protected const ENDPOINT = 'request';

    /** @var list<string> */
    protected const REQUIRED = [];

    /** @var list<list<string>> */
    protected const REQUIRED_ALTERNATIVES = [];

    /** @var array<string, mixed> */
    protected const DEFAULTS = [];

    /** @var array<string, mixed> */
    protected array $parameters;

    public function __construct(protected readonly RequestExecutorInterface $executor, protected ApiVersion $apiVersion = ApiVersion::V7)
    {
        $this->parameters = static::DEFAULTS;
    }

    public function version(ApiVersion|int|string $version): static
    {
        $copy = clone $this;
        $copy->apiVersion = ApiVersion::resolve($version);

        return $copy;
    }

    public function withParameter(string $name, mixed $value): static
    {
        if (in_array($name, ['action', 'version', 'public_key', 'private_key', 'data', 'signature'], true) || trim($name) === '') {
            throw new InvalidArgumentException('This parameter is reserved; use a dedicated fluent method where available.');
        }

        $copy = clone $this;
        $copy->parameters[$name] = $value;

        return $copy;
    }

    /** @param array<string, mixed> $parameters */
    public function withParameters(array $parameters): static
    {
        $copy = $this;

        foreach ($parameters as $name => $value) {
            $copy = $copy->withParameter($name, $value);
        }

        return $copy;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return ['action' => static::ACTION, 'version' => $this->apiVersion->value, ...$this->parameters];
    }

    /** @return TResponse */
    public function send(): mixed
    {
        $this->validate();
        // Project the documented wire contract into static analysis without altering the value.
        /** @var TResponse $response */
        $response = $this->executor->execute(static::ENDPOINT, $this->toArray(), $this->apiVersion);

        return $response;
    }

    protected function validate(): void
    {
        foreach (static::REQUIRED as $field) {
            if (! array_key_exists($field, $this->parameters) || $this->parameters[$field] === null
                || (is_string($this->parameters[$field]) && trim($this->parameters[$field]) === '')) {
                throw new InvalidArgumentException(static::ACTION.' requires '.$field.'.');
            }
        }

        if (static::REQUIRED_ALTERNATIVES !== []) {
            $complete = false;
            foreach (static::REQUIRED_ALTERNATIVES as $group) {
                $present = true;
                foreach ($group as $field) {
                    $value = $this->parameters[$field] ?? null;
                    if ($value === null || (is_string($value) && trim($value) === '')) {
                        $present = false;
                    }
                }
                $complete = $complete || $present;
            }
            if (! $complete) {
                $groups = array_map(static fn (array $group): string => implode(' + ', $group), static::REQUIRED_ALTERNATIVES);
                throw new InvalidArgumentException(static::ACTION.' requires one complete parameter group: '.implode(' or ', $groups).'.');
            }
        }

        if (isset($this->parameters['amount'])) {
            $amount = $this->parameters['amount'];
            if ((! is_string($amount) && ! is_int($amount) && ! is_float($amount)) || ! is_numeric($amount)
                || ! is_finite((float) $amount) || (float) $amount <= 0) {
                throw new InvalidArgumentException('Amount must be a positive finite number or decimal string.');
            }
        }

        if (isset($this->parameters['order_id']) && is_string($this->parameters['order_id']) && strlen($this->parameters['order_id']) > 255) {
            throw new InvalidArgumentException('Order ID must not exceed 255 bytes.');
        }
    }
}
