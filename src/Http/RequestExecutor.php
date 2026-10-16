<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Http;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Configuration;
use Andriichuk\LiqPay\Contract\RequestExecutorInterface;
use Andriichuk\LiqPay\Contract\SignerInterface;
use Andriichuk\LiqPay\Contract\TransportInterface;
use Andriichuk\LiqPay\Crypto\PayloadCodec;
use InvalidArgumentException;

/**
 * @phpstan-import-type CheckoutPayload from \Andriichuk\LiqPay\Contract\RequestExecutorInterface
 */
final readonly class RequestExecutor implements RequestExecutorInterface
{
    public function __construct(
        private string $publicKey,
        private Configuration $configuration,
        private TransportInterface $transport,
        private SignerInterface $signer,
        private PayloadCodec $codec,
    ) {}

    public function execute(string $endpoint, array $parameters, ApiVersion $version): mixed
    {
        if ($endpoint === 'publicExchange' || $endpoint === 'publicArchive') {
            unset($parameters['action'], $parameters['version']);
            $parameters['json'] = '';
            $query = [];
            foreach ($parameters as $name => $value) {
                if (! is_scalar($value)) {
                    throw new InvalidArgumentException('Public API query parameters must be scalar values.');
                }
                $query[$name] = $value;
            }

            return $this->transport->get(
                rtrim($this->configuration->publicBaseUri, '/').'/'.($endpoint === 'publicExchange' ? 'pubinfo' : 'exchange_rates'),
                $query,
            );
        }
        if ($endpoint === 'request') {
            $parameters['public_key'] = $this->publicKey;
            $parameters['version'] = $version->value;
            $url = rtrim($this->configuration->apiBaseUri, '/').'/request';
        } else {
            // The POS protocol does not carry LiqPay merchant public_key/version fields.
            unset($parameters['version']);
            $version = ApiVersion::V7;
            $url = match ($endpoint) {
                'posData' => $this->configuration->posDataUrl,
                'posCallback' => $this->configuration->posCallbackUrl,
                'posRequest' => $this->configuration->posRequestUrl,
                default => throw new InvalidArgumentException('Unknown endpoint.'),
            };
        }
        $data = $this->codec->encode($parameters);
        $raw = in_array($parameters['action'] ?? '', ['reports', 'reports_compensation', 'register'], true) && in_array($parameters['resp_format'] ?? $parameters['format'] ?? 'json', ['csv', 'xml', 'CSV', 'XML'], true);

        return $this->transport->post($url, ['data' => $data, 'signature' => $this->signer->sign($data, $version)], $endpoint !== 'request', $raw);
    }

    /** @return CheckoutPayload */
    public function checkout(array $parameters, ApiVersion $version): array
    {
        $parameters['public_key'] = $this->publicKey;
        $parameters['version'] = $version->value;
        $data = $this->codec->encode($parameters);

        return ['url' => $this->configuration->checkoutUrl, 'data' => $data, 'signature' => $this->signer->sign($data, $version)];
    }
}
