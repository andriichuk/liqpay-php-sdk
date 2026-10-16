<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay;

use Andriichuk\LiqPay\Contract\SignerInterface;
use Andriichuk\LiqPay\Crypto\PayloadCodec;
use Andriichuk\LiqPay\Exception\InvalidSignatureException;
use InvalidArgumentException;

/**
 * @see https://www.liqpay.ua/en/doc/api/callback
 * @see https://www.liqpay.ua/en/doc/api/POS/order_payment
 *
 * @phpstan-import-type PosReceiver from \Andriichuk\LiqPay\Request\PosReceiversStatusRequest
 * @phpstan-import-type PosRefundTransaction from \Andriichuk\LiqPay\Request\PosRefundBillRequest
 *
 * @phpstan-type PaymentCallback array{
 *     acq_id?: int|numeric-string, // Acquirer identifier.
 *     action?: string, // Operation type.
 *     agent_commission?: int|float|numeric-string, // Agent fee in payment currency.
 *     amount?: int|float|numeric-string, // Payment amount.
 *     amount_bonus?: int|float|numeric-string, // Sender bonus in debit currency.
 *     amount_credit?: int|float|numeric-string, // Credit amount in credit currency.
 *     amount_debit?: int|float|numeric-string, // Debit amount in debit currency.
 *     authcode_credit?: string, // Credit authorization code.
 *     authcode_debit?: string, // Debit authorization code.
 *     card_token?: string, // LiqPay card token.
 *     commission_credit?: int|float|numeric-string, // Recipient fee in credit currency.
 *     commission_debit?: int|float|numeric-string, // Sender fee in debit currency.
 *     completion_date?: int|string, // Funds capture date.
 *     create_date?: int|string, // Creation date.
 *     currency?: string, // Payment currency.
 *     currency_credit?: string, // Credit currency.
 *     currency_debit?: string, // Debit currency.
 *     customer?: string|null, // Merchant customer identifier.
 *     description?: string, // Payment or company description.
 *     end_date?: int|string, // Completion or modification date.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     info?: string, // Additional payment information.
 *     ip?: string, // Sender IP address.
 *     is_3ds?: bool|'true'|'false', // Whether 3-D Secure was used; examples also use string booleans.
 *     liqpay_order_id?: string, // LiqPay order identifier.
 *     mpi_eci?: int|numeric-string, // 3-D Secure ECI indicator: 5, 6 or 7.
 *     order_id?: string, // Merchant order identifier.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     paytype?: string, // Payment method.
 *     public_key?: string, // Merchant public key.
 *     receiver_commission?: int|float|numeric-string, // Recipient fee in payment currency.
 *     redirect_to?: string, // URL for customer 3-D Secure verification.
 *     refund_date_last?: int|string, // Most recent refund date.
 *     rrn_credit?: string, // Credit retrieval reference number.
 *     rrn_debit?: string, // Debit retrieval reference number.
 *     sender_bonus?: int|float|numeric-string, // Sender bonus in payment currency.
 *     sender_card_bank?: string, // Sender card issuer.
 *     sender_card_country?: int|string, // Card country, numeric ISO 3166-1 code.
 *     sender_card_mask2?: string, // Masked sender card.
 *     sender_iban?: string, // Sender IBAN.
 *     sender_card_type?: string, // Sender card network: MC or Visa.
 *     sender_commission?: int|float|numeric-string, // Sender fee in payment currency.
 *     sender_first_name?: string, // Sender given name.
 *     sender_last_name?: string, // Sender surname.
 *     sender_phone?: string, // Sender phone.
 *     status?: string, // Status: error, failure, reversed, subscribed, success, unsubscribed, captcha_verify, cvv_verify, ivr_verify, otp_verify, password_verify, phone_verify, pin_verify, pin, senderapp_verify, wait_qr, QR, wait_sender, cash_wait, hold_wait, invoice_wait, prepared, processing, wait_accept, wait_card, wait_compensation, wait_lc, wait_reserve, wait_secure.
 *     wait_reserve_status?: string, // Whether the payment is reserved for a refund.
 *     token?: string, // Payment token.
 *     type?: string, // Payment type.
 *     version?: int|numeric-string, // API version.
 *     err_erc?: string, // Additional error code.
 *     product_category?: string, // Product category.
 *     product_description?: string, // Product description.
 *     product_name?: string, // Product name.
 *     product_url?: string, // Product page URL.
 *     refund_amount?: int|float|numeric-string, // Refunded amount.
 *     verifycode?: string, // Verification code.
 * }
 * @phpstan-type PosBillItem array{
 *     name?: string, // Bill item name.
 *     item_id?: string, // Bill item identifier.
 *     price?: int|float|numeric-string, // Item price.
 *     total?: int|float|numeric-string, // Item total.
 *     quantity?: int|float|numeric-string, // Item quantity.
 *     receiver_id?: string, // Receiver identifier.
 *     discount?: int|float|numeric-string, // Item discount.
 * }
 * @phpstan-type PosBill array{
 *     id?: string, // Bill identifier.
 *     number?: string, // Bill number.
 *     subtotal_amount?: int|float|numeric-string, // Bill subtotal.
 *     total_amount?: int|float|numeric-string, // Bill total.
 *     waiter_id?: string, // Waiter identifier.
 *     can_split?: bool|'true'|'false', // Whether the bill can be split.
 *     items?: list<PosBillItem>, // Bill line items.
 * }
 * @phpstan-type PosCallback array{
 *     req_id?: string, // Original request correlation identifier.
 *     id_company_in_pos?: string, // Venue identifier in the POS system.
 *     action?: string, // Operation type.
 *     table_id?: string, // Table identifier.
 *     status?: string, // Status: success, error.
 *     bills?: list<PosBill>, // Bills for the requested table.
 *     payment_id?: int|numeric-string, // LiqPay payment identifier.
 *     bill_id?: string, // Bill identifier.
 *     bill_number?: string, // Bill number.
 *     payment_type?: string, // Payment channel description.
 *     payment_method?: string, // Payment method description.
 *     bill_amount?: int|float|numeric-string, // Bill amount.
 *     merchant_id?: string, // Merchant identifier.
 *     rrn?: int|float|numeric-string, // Payment retrieval reference.
 *     terminal?: string, // Terminal identifier.
 *     card_mask?: string, // Masked payment card.
 *     auth_code?: string, // Authorization code.
 *     card_type?: string, // Card network.
 *     acquirer_bank?: string, // Acquiring bank.
 *     tips_amount?: int|float|numeric-string, // Tip amount.
 *     to_bill_id?: string, // Destination bill identifier.
 *     items_to_split?: list<PosSplitItem>, // Items selected for splitting into another bill.
 *     new_bill_id?: string, // Newly split bill identifier.
 *     pos_system?: string, // POS system name.
 *     err_code?: string, // Error code.
 *     err_description?: string, // Error description.
 *     receivers?: list<PosReceiver>, // Payment receiver records.
 *     payments_success?: list<PosRefundTransaction>, // Successful refund transactions.
 *     payments_error?: list<PosRefundTransaction>, // Failed refund transactions.
 * }
 * @phpstan-type PosSplitItem array{
 *     item_id?: int|float|numeric-string, // Bill item identifier.
 *     cnt?: int|float|numeric-string, // Item quantity moved to the split bill.
 * }
 */
final readonly class Callback
{
    public function __construct(private string $publicKey, private SignerInterface $signer, private PayloadCodec $codec, private ApiVersion $expectedVersion = ApiVersion::V7) {}

    /** @return PaymentCallback */
    public function verify(string $data, string $signature, ApiVersion|int|string|null $version = null): array
    {
        $version = ApiVersion::resolve($version ?? $this->expectedVersion);
        if (! $this->signer->verify($data, $signature, $version)) {
            throw new InvalidSignatureException('Callback signature does not match.');
        }
        $payload = $this->codec->decode($data);
        if (($payload['public_key'] ?? null) !== $this->publicKey) {
            throw new InvalidArgumentException('Callback public key does not match this client.');
        }
        if (isset($payload['version']) && ((! is_int($payload['version']) && ! is_string($payload['version'])) || (string) $payload['version'] !== (string) $version->value)) {
            throw new InvalidArgumentException('Callback API version does not match the expected version.');
        }

        /** @var PaymentCallback $payload */
        return $payload;
    }

    /** Verify a POS callback, whose schema has no merchant public_key/version.
     * @return PosCallback
     */
    public function verifyPos(string $data, string $signature): array
    {
        if (! $this->signer->verify($data, $signature, ApiVersion::V7)) {
            throw new InvalidSignatureException('Callback signature does not match.');
        }
        /** @var PosCallback $payload */
        $payload = $this->codec->decode($data);

        return $payload;
    }
}
