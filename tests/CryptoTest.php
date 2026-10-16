<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests;

use Andriichuk\LiqPay\ApiVersion;
use Andriichuk\LiqPay\Configuration;
use Andriichuk\LiqPay\Crypto\PayloadCodec;
use Andriichuk\LiqPay\Crypto\Signer;
use Andriichuk\LiqPay\Exception\InvalidSignatureException;
use Andriichuk\LiqPay\LiqPay;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CryptoTest extends TestCase
{
    public function test_official_v7_signing_vector(): void
    {
        $data = 'eyJwdWJsaWNfa2V5IjoiaTAwMDAwMDAwIiwidmVyc2lvbiI6NywiYWN0aW9uIjoicGF5IiwiYW1vdW50IjoiMyIsImN1cnJlbmN5IjoiVUFIIiwiZGVzY3JpcHRpb24iOiJ0ZXN0Iiwib3JkZXJfaWQiOiIwMDAwMDEifQ==';
        $signer = new Signer('a4825234f4bae72a0be04eafe9e8e2bada209255');
        self::assertSame('0adgJ8F2Ds5HCVkcz4AlmdLMRoIJf7IxsL3QmeFRz/s=', $signer->sign($data, ApiVersion::V7));
        self::assertTrue($signer->verify($data, '0adgJ8F2Ds5HCVkcz4AlmdLMRoIJf7IxsL3QmeFRz/s=', ApiVersion::V7));
        self::assertFalse($signer->verify($data.'x', '0adgJ8F2Ds5HCVkcz4AlmdLMRoIJf7IxsL3QmeFRz/s=', ApiVersion::V7));
    }

    public function test_legacy_signature_has_independent_known_answer(): void
    {
        self::assertSame('etTZWfwujVUMqsM6nkJdkVMEdb8=', (new Signer('secret'))->sign('data', ApiVersion::V3));
    }

    public function test_callback_preserves_types(): void
    {
        $payload = ['version' => 7, 'public_key' => 'public', 'payment_id' => '42', 'status' => 'success', 'amount' => 1.5, 'is_3ds' => false, 'info' => null];
        $data = (new PayloadCodec)->encode($payload);
        self::assertSame($payload, (new LiqPay('public', 'secret'))->callback()->verify($data, (new Signer('secret'))->sign($data, ApiVersion::V7)));
    }

    public function test_callbacks_reject_tampering_before_decoding(): void
    {
        $this->expectException(InvalidSignatureException::class);
        (new LiqPay('public', 'secret'))->callback()->verify('this is not JSON', 'bad');
    }

    public function test_callback_does_not_automatically_downgrade_to_sha1(): void
    {
        $data = (new PayloadCodec)->encode(['public_key' => 'public', 'version' => 3]);
        $this->expectException(InvalidSignatureException::class);
        (new LiqPay('public', 'secret'))->callback()->verify($data, (new Signer('secret'))->sign($data, ApiVersion::V3));
    }

    public function test_explicit_and_configured_legacy_callback_version(): void
    {
        $data = (new PayloadCodec)->encode(['public_key' => 'public', 'version' => '3']);
        $signature = (new Signer('secret'))->sign($data, ApiVersion::V3);
        self::assertSame('3', (new LiqPay('public', 'secret'))->callback()->verify($data, $signature, '3')['version']);
        $client = new LiqPay('public', 'secret', configuration: new Configuration(apiVersion: ApiVersion::V3));
        self::assertSame('3', $client->callback()->verify($data, $signature)['version']);
    }

    public function test_wrong_merchant_is_rejected(): void
    {
        $data = (new PayloadCodec)->encode(['public_key' => 'other', 'version' => 7]);
        $this->expectException(\InvalidArgumentException::class);
        (new LiqPay('public', 'secret'))->callback()->verify($data, (new Signer('secret'))->sign($data, ApiVersion::V7));
    }

    public function test_mismatched_payload_version_is_rejected(): void
    {
        $data = (new PayloadCodec)->encode(['public_key' => 'public', 'version' => 3]);
        $this->expectException(\InvalidArgumentException::class);
        (new LiqPay('public', 'secret'))->callback()->verify($data, (new Signer('secret'))->sign($data, ApiVersion::V7));
    }

    public function test_pos_callbacks_have_no_merchant_or_version_fields(): void
    {
        $payload = ['action' => 'get_bills', 'req_id' => 'req', 'id_company_in_pos' => 'company'];
        $data = (new PayloadCodec)->encode($payload);
        self::assertSame($payload, (new LiqPay('public', 'secret'))->callback()->verifyPos($data, (new Signer('secret'))->sign($data, ApiVersion::V7)));
    }

    public function test_pos_callback_rejects_invalid_signature(): void
    {
        $this->expectException(InvalidSignatureException::class);
        (new LiqPay('public', 'secret'))->callback()->verifyPos('data', 'bad');
    }

    public static function badPayloads(): iterable
    {
        foreach (['not base64!', base64_encode('{bad'), base64_encode('[]'), base64_encode('null'), base64_encode('"string"')] as $data) {
            yield [$data];
        }
    }

    #[DataProvider('badPayloads')]
    public function test_malformed_payload_is_rejected(string $data): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new PayloadCodec)->decode($data);
    }

    public function test_non_encodable_parameters_are_rejected(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        (new PayloadCodec)->encode(['value' => NAN]);
    }

    public function test_signer_debug_output_redacts_secret(): void
    {
        ob_start();
        var_dump(new Signer('private-key-never-print'));
        $output = ob_get_clean();
        self::assertStringNotContainsString('private-key-never-print', $output);
        self::assertStringContainsString('[redacted]', $output);
    }

    public static function badVersions(): iterable
    {
        foreach ([0, 2, 6, 8, '03', '7.0', 'latest', ''] as $version) {
            yield [$version];
        }
    }

    #[DataProvider('badVersions')]
    public function test_unknown_versions_are_rejected(int|string $version): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ApiVersion::resolve($version);
    }
}
