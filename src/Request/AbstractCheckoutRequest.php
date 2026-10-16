<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Request;

use InvalidArgumentException;

/**
 * @phpstan-import-type CheckoutPayload from \Andriichuk\LiqPay\Contract\RequestExecutorInterface
 *
 * @extends AbstractRequest<CheckoutPayload>
 */
abstract class AbstractCheckoutRequest extends AbstractRequest
{
    public function action(string $action): static
    {
        if (! in_array($action, ['pay', 'hold', 'subscribe', 'paydonate', 'auth'], true)) {
            throw new InvalidArgumentException('Unsupported checkout action.');
        }

        $copy = clone $this;
        $copy->parameters['action'] = $action;

        return $copy;
    }

    /** @return CheckoutPayload */
    public function payload(): array
    {
        $this->validate();

        return $this->executor->checkout($this->toArray(), $this->apiVersion);
    }

    /**
     * @return CheckoutPayload
     */
    public function send(): array
    {
        return $this->payload();
    }

    public function form(string $label = 'Pay'): string
    {
        $payload = $this->payload();
        $escape = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return '<form method="POST" action="'.$escape($payload['url']).'" accept-charset="utf-8">'
            .'<input type="hidden" name="data" value="'.$escape($payload['data']).'">'
            .'<input type="hidden" name="signature" value="'.$escape($payload['signature']).'">'
            .'<button type="submit">'.$escape($label).'</button></form>';
    }
}
