# Response array shapes

Responses stay native PHP arrays. The `@phpstan-type` specs live on the existing request classes, callback verifier and executor contract. Shared nested shapes use `@phpstan-import-type` from those classes. There are no response placeholder classes or extra PHPStan configuration files to include.

Each fluent JSON operation binds `AbstractRequest<TResponse>` to its response alias. `send()` exposes that alias to PHPStan; fluent setters and `version()` preserve it. Checkout helpers use the shared `CheckoutPayload` shape. Callback verification returns the documented `PaymentCallback` or `PosCallback` shape.

PHPStan 2.3.1 or newer is required to parse inline field comments. Field comments summarize the linked LiqPay documentation in English. `@see` links identify the source page. Nested records use separate imported shapes so their fields also support completion and analysis.

## Example

```php
/**
 * @phpstan-import-type RefundResponse from \Andriichuk\LiqPay\Request\RefundRequest
 */
final class RefundService
{
    /** @return RefundResponse */
    public function refund(\Andriichuk\LiqPay\LiqPay $client, string $orderId): array
    {
        return $client->refund()->orderId($orderId)->amount('19.90')->send();
    }
}
```

The refund alias describes `result`, `status`, `payment_id`, `wait_amount` and error fields, with a comment beside every field. Identifiers allow numeric strings, and the refund boolean allows both native booleans and the quoted values in the documentation example.

## Contract details

- Fields that can be omitted on failures, intermediate statuses or configuration variants are optional. Check `isset()` or use `??` before reading them. POS acknowledgement `status` and all local checkout payload fields are required by their documented contracts.
- JSON number fields allow native integers, floats and numeric strings as appropriate. Documented nullable values retain `null`. Values are never normalized to satisfy a type annotation.
- Report operations use a shape-or-string union because CSV/XML downloads remain strings. Asynchronous report creation/polling have their own shaped JSON envelopes.
- List responses describe their element shapes. This includes invoice units, current and historical rates, token-network details, MCC codes/document identifiers, report rows and POS records.
- Shape annotations describe documented fields; the runtime preserves additional server fields and does not enforce or strip response schemas. The generic projection at the HTTP boundary and callback annotations trust the API contract.
- The PrivatPay guide does not identify the response field holding the payment link. Its alias describes only common error fields instead of guessing the link key.
- The P2P debit guide omits a response table. Its alias references the documented payment callback fields and records that limitation.
- The invoice-unit guide describes a list and localized fields, without specifying another JSON envelope. The alias follows that list plus the common error shape.
- The MCC `alt_docs` field is a list of document identifiers, not nested document objects. Unspecified operator comment entries remain `list<mixed>`.

## Operation mapping

| Operation | Shape alias | Definition |
| --- | --- | --- |
| `$client->refund()->send()` | `RefundResponse` | [RefundRequest](../src/Request/RefundRequest.php) |
| `$client->payment()->send()` | `PaymentResponse` | [PaymentRequest](../src/Request/PaymentRequest.php) |
| `$client->checkout()->send()` | `CheckoutResponse` | [CheckoutRequest](../src/Request/CheckoutRequest.php) |
| `$client->widget()->send()` | `WidgetResponse` | [WidgetRequest](../src/Request/WidgetRequest.php) |
| `$client->donation()->send()` | `DonationResponse` | [DonationRequest](../src/Request/DonationRequest.php) |
| `$client->authorization()->send()` | `AuthorizationResponse` | [AuthorizationRequest](../src/Request/AuthorizationRequest.php) |
| `$client->privatPay()->send()` | `PrivatPayResponse` | [PrivatPayRequest](../src/Request/PrivatPayRequest.php) |
| `$client->applePay()->send()` | `ApplePayResponse` | [ApplePayRequest](../src/Request/ApplePayRequest.php) |
| `$client->googlePay()->send()` | `GooglePayResponse` | [GooglePayRequest](../src/Request/GooglePayRequest.php) |
| `$client->tokenPayment()->send()` | `TokenPaymentResponse` | [TokenPaymentRequest](../src/Request/TokenPaymentRequest.php) |
| `$client->cash()->send()` | `CashResponse` | [CashRequest](../src/Request/CashRequest.php) |
| `$client->qr()->send()` | `QrResponse` | [QrRequest](../src/Request/QrRequest.php) |
| `$client->staticQr()->send()` | `StaticQrResponse` | [StaticQrRequest](../src/Request/StaticQrRequest.php) |
| `$client->hold()->send()` | `HoldResponse` | [HoldRequest](../src/Request/HoldRequest.php) |
| `$client->capture()->send()` | `CaptureResponse` | [CaptureRequest](../src/Request/CaptureRequest.php) |
| `$client->dcc()->send()` | `DccResponse` | [DccRequest](../src/Request/DccRequest.php) |
| `$client->subscriptions()->create()->send()` | `SubscriptionCreateResponse` | [SubscriptionCreateRequest](../src/Request/SubscriptionCreateRequest.php) |
| `$client->subscriptions()->cancel()->send()` | `SubscriptionCancelResponse` | [SubscriptionCancelRequest](../src/Request/SubscriptionCancelRequest.php) |
| `$client->subscriptions()->update()->send()` | `SubscriptionUpdateResponse` | [SubscriptionUpdateRequest](../src/Request/SubscriptionUpdateRequest.php) |
| `$client->invoices()->create()->send()` | `InvoiceCreateResponse` | [InvoiceCreateRequest](../src/Request/InvoiceCreateRequest.php) |
| `$client->invoices()->cancel()->send()` | `InvoiceCancelResponse` | [InvoiceCancelRequest](../src/Request/InvoiceCancelRequest.php) |
| `$client->invoices()->units()->send()` | `InvoiceUnitsResponse` | [InvoiceUnitsRequest](../src/Request/InvoiceUnitsRequest.php) |
| `$client->tokens()->create()->send()` | `TokenCreateResponse` | [TokenCreateRequest](../src/Request/TokenCreateRequest.php) |
| `$client->tokens()->createUnique()->send()` | `TokenCreateUniqueResponse` | [TokenCreateUniqueRequest](../src/Request/TokenCreateUniqueRequest.php) |
| `$client->tokens()->update()->send()` | `TokenUpdateResponse` | [TokenUpdateRequest](../src/Request/TokenUpdateRequest.php) |
| `$client->confirmations()->threeDs()->send()` | `Confirm3dsResponse` | [Confirm3dsRequest](../src/Request/Confirm3dsRequest.php) |
| `$client->confirmations()->cvv()->send()` | `ConfirmCvvResponse` | [ConfirmCvvRequest](../src/Request/ConfirmCvvRequest.php) |
| `$client->confirmations()->otp()->send()` | `ConfirmOtpResponse` | [ConfirmOtpRequest](../src/Request/ConfirmOtpRequest.php) |
| `$client->information()->status()->send()` | `StatusResponse` | [StatusRequest](../src/Request/StatusRequest.php) |
| `$client->information()->data()->send()` | `PaymentDataResponse` | [PaymentDataRequest](../src/Request/PaymentDataRequest.php) |
| `$client->information()->receipt()->send()` | `ReceiptResponse` | [ReceiptRequest](../src/Request/ReceiptRequest.php) |
| `$client->information()->reports()->send()` | `ReportsResponse` | [ReportsRequest](../src/Request/ReportsRequest.php) |
| `$client->information()->compensation()->send()` | `CompensationResponse` | [CompensationRequest](../src/Request/CompensationRequest.php) |
| `$client->information()->register()->send()` | `RegisterResponse` | [RegisterRequest](../src/Request/RegisterRequest.php) |
| `$client->information()->compensationFile()->send()` | `CompensationFileResponse` | [CompensationFileRequest](../src/Request/CompensationFileRequest.php) |
| `$client->information()->compensationFileStatus()->send()` | `CompensationFileStatusResponse` | [CompensationFileStatusRequest](../src/Request/CompensationFileStatusRequest.php) |
| `$client->transfers()->toCard()->send()` | `TransferToCardResponse` | [TransferToCardRequest](../src/Request/TransferToCardRequest.php) |
| `$client->transfers()->toAccount()->send()` | `TransferToAccountResponse` | [TransferToAccountRequest](../src/Request/TransferToAccountRequest.php) |
| `$client->partnerships()->createMerchant()->send()` | `MerchantCreateResponse` | [MerchantCreateRequest](../src/Request/MerchantCreateRequest.php) |
| `$client->partnerships()->registerMerchant()->send()` | `MerchantRegisterResponse` | [MerchantRegisterRequest](../src/Request/MerchantRegisterRequest.php) |
| `$client->partnerships()->editMerchant()->send()` | `MerchantEditResponse` | [MerchantEditRequest](../src/Request/MerchantEditRequest.php) |
| `$client->partnerships()->merchantInfo()->send()` | `MerchantInfoResponse` | [MerchantInfoRequest](../src/Request/MerchantInfoRequest.php) |
| `$client->partnerships()->userInfo()->send()` | `UserInfoResponse` | [UserInfoRequest](../src/Request/UserInfoRequest.php) |
| `$client->partnerships()->mccCodes()->send()` | `MccCodesResponse` | [MccCodesRequest](../src/Request/MccCodesRequest.php) |
| `$client->partnerships()->mccDocuments()->send()` | `MccDocumentsResponse` | [MccDocumentsRequest](../src/Request/MccDocumentsRequest.php) |
| `$client->publicApi()->exchangeRates()->send()` | `ExchangeRatesResponse` | [ExchangeRatesRequest](../src/Request/ExchangeRatesRequest.php) |
| `$client->publicApi()->exchangeArchive()->send()` | `ExchangeArchiveResponse` | [ExchangeArchiveRequest](../src/Request/ExchangeArchiveRequest.php) |
| `$client->pos()->receivers()->send()` | `PosReceiversResponse` | [PosReceiversRequest](../src/Request/PosReceiversRequest.php) |
| `$client->pos()->waiters()->send()` | `PosWaitersResponse` | [PosWaitersRequest](../src/Request/PosWaitersRequest.php) |
| `$client->pos()->tables()->send()` | `PosTablesResponse` | [PosTablesRequest](../src/Request/PosTablesRequest.php) |
| `$client->pos()->companyStatus()->send()` | `PosCompanyStatusResponse` | [PosCompanyStatusRequest](../src/Request/PosCompanyStatusRequest.php) |
| `$client->pos()->receiversStatus()->send()` | `PosReceiversStatusResponse` | [PosReceiversStatusRequest](../src/Request/PosReceiversStatusRequest.php) |
| `$client->pos()->waitersStatus()->send()` | `PosWaitersStatusResponse` | [PosWaitersStatusRequest](../src/Request/PosWaitersStatusRequest.php) |
| `$client->pos()->tablesStatus()->send()` | `PosTablesStatusResponse` | [PosTablesStatusRequest](../src/Request/PosTablesStatusRequest.php) |
| `$client->pos()->allCompaniesStatus()->send()` | `PosAllCompaniesStatusResponse` | [PosAllCompaniesStatusRequest](../src/Request/PosAllCompaniesStatusRequest.php) |
| `$client->pos()->bills()->send()` | `PosBillsResponse` | [PosBillsRequest](../src/Request/PosBillsRequest.php) |
| `$client->pos()->splitBills()->send()` | `PosSplitBillsResponse` | [PosSplitBillsRequest](../src/Request/PosSplitBillsRequest.php) |
| `$client->pos()->refundBill()->send()` | `PosRefundBillResponse` | [PosRefundBillRequest](../src/Request/PosRefundBillRequest.php) |

## Verification

`tests/Types/responses.php` compiles calls through all 58 fluent entry points and both callback verification methods. 90 PHPStan `assertType()` assertions check ordinary fields and nested values, so a regression to `mixed` or an incorrect field type fails `composer analyse`. These are static fixtures and never execute payment requests.

The machine-readable inventory in `response-shapes.json` keeps the source field type and description alongside each alias. It is a documentation reference, not a runtime response mapper.
