# Endpoint coverage

All concrete operations have fixture-based wire tests in `tests/EndpointTest.php`. Missing required fields and alternative funding methods are tested before transmission. Native response types, transport failures and callback signing are tested independently.

The API documentation often retains v3 examples beside v7 parameter tables. The package follows the v7 parameter tables and SHA3-256 signing, with an explicit v3 compatibility mode.

| Fluent entry point | Request class | Action | Destination | Documentation |
| --- | --- | --- | --- | --- |
| `$liqpay->refund()` | `RefundRequest` | `refund` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/refund) |
| `$liqpay->payment()` | `PaymentRequest` | `pay` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/card_payment) |
| `$liqpay->checkout()` | `CheckoutRequest` | `pay` | Local checkout payload | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/checkout) |
| `$liqpay->widget()` | `WidgetRequest` | `pay` | Local checkout payload | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/widget) |
| `$liqpay->donation()` | `DonationRequest` | `paydonate` | Local checkout payload | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/checkout) |
| `$liqpay->authorization()` | `AuthorizationRequest` | `auth` | Local checkout payload | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/checkout) |
| `$liqpay->privatPay()` | `PrivatPayRequest` | `payment_prepare` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/privat_pay) |
| `$liqpay->applePay()` | `ApplePayRequest` | `pay` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/apay) |
| `$liqpay->googlePay()` | `GooglePayRequest` | `pay` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/gpay) |
| `$liqpay->tokenPayment()` | `TokenPaymentRequest` | `paytoken` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/token) |
| `$liqpay->cash()` | `CashRequest` | `paycash` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/cash) |
| `$liqpay->qr()` | `QrRequest` | `payqr` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/qr) |
| `$liqpay->staticQr()` | `StaticQrRequest` | `staticQrCreate` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/qr) |
| `$liqpay->hold()` | `HoldRequest` | `hold` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/two_step) |
| `$liqpay->capture()` | `CaptureRequest` | `hold_completion` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/two_step) |
| `$liqpay->dcc()` | `DccRequest` | `pay` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/dcc) |
| `$liqpay->subscriptions()->create()` | `SubscriptionCreateRequest` | `subscribe` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/subscription) |
| `$liqpay->subscriptions()->cancel()` | `SubscriptionCancelRequest` | `unsubscribe` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/subscription) |
| `$liqpay->subscriptions()->update()` | `SubscriptionUpdateRequest` | `subscribe_update` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/subscription) |
| `$liqpay->invoices()->create()` | `InvoiceCreateRequest` | `invoice_send` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice) |
| `$liqpay->invoices()->cancel()` | `InvoiceCancelRequest` | `invoice_cancel` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice) |
| `$liqpay->invoices()->units()` | `InvoiceUnitsRequest` | `invoice_units_get_list` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/internet_acquiring/invoice) |
| `$liqpay->tokens()->create()` | `TokenCreateRequest` | `token_create` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/tokens) |
| `$liqpay->tokens()->createUnique()` | `TokenCreateUniqueRequest` | `token_create_unique` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/tokens) |
| `$liqpay->tokens()->update()` | `TokenUpdateRequest` | `token_update` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/tokens) |
| `$liqpay->confirmations()->threeDs()` | `Confirm3dsRequest` | `confirm` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/confirmation/3ds) |
| `$liqpay->confirmations()->cvv()` | `ConfirmCvvRequest` | `confirm` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/confirmation/CVV) |
| `$liqpay->confirmations()->otp()` | `ConfirmOtpRequest` | `confirm` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/confirmation/OTP) |
| `$liqpay->information()->status()` | `StatusRequest` | `status` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/status_payment) |
| `$liqpay->information()->data()` | `PaymentDataRequest` | `data` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/adding_data) |
| `$liqpay->information()->receipt()` | `ReceiptRequest` | `ticket` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/receive_a_receipt) |
| `$liqpay->information()->reports()` | `ReportsRequest` | `reports` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/payment_archive) |
| `$liqpay->information()->compensation()` | `CompensationRequest` | `reports_compensation` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/register) |
| `$liqpay->information()->register()` | `RegisterRequest` | `register` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/register) |
| `$liqpay->information()->compensationFile()` | `CompensationFileRequest` | `reports_compensation_file` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/register) |
| `$liqpay->information()->compensationFileStatus()` | `CompensationFileStatusRequest` | `reports_compensation_file_status` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/information/register) |
| `$liqpay->transfers()->toCard()` | `TransferToCardRequest` | `p2pcredit` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/transferring_to_card) |
| `$liqpay->transfers()->toAccount()` | `TransferToAccountRequest` | `p2pdebit` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/p2pdebit) |
| `$liqpay->partnerships()->createMerchant()` | `MerchantCreateRequest` | `agent_shop_create` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/shop_create) |
| `$liqpay->partnerships()->registerMerchant()` | `MerchantRegisterRequest` | `agent_shop_register` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/shop_create) |
| `$liqpay->partnerships()->editMerchant()` | `MerchantEditRequest` | `agent_shop_edit` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/shop_edit) |
| `$liqpay->partnerships()->merchantInfo()` | `MerchantInfoRequest` | `agent_info_merchant` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/info_merchant) |
| `$liqpay->partnerships()->userInfo()` | `UserInfoRequest` | `agent_info_user` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/info_user) |
| `$liqpay->partnerships()->mccCodes()` | `MccCodesRequest` | `agent_info_mcc_codes` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/shop_create) |
| `$liqpay->partnerships()->mccDocuments()` | `MccDocumentsRequest` | `agent_info_mcc_docs` | POST `/api/request` | [Reference](https://www.liqpay.ua/en/doc/api/partnership/shop_create) |
| `$liqpay->publicApi()->exchangeRates()` | `ExchangeRatesRequest` | `` | GET PrivatBank `/p24api/pubinfo` | [Reference](https://www.liqpay.ua/en/doc/api/public/exchange) |
| `$liqpay->publicApi()->exchangeArchive()` | `ExchangeArchiveRequest` | `` | GET PrivatBank `/p24api/exchange_rates` | [Reference](https://www.liqpay.ua/en/doc/api/public/archive) |
| `$liqpay->pos()->receivers()` | `PosReceiversRequest` | `get_receivers` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_creation) |
| `$liqpay->pos()->waiters()` | `PosWaitersRequest` | `get_waiters` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_creation) |
| `$liqpay->pos()->tables()` | `PosTablesRequest` | `get_tables` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_creation) |
| `$liqpay->pos()->companyStatus()` | `PosCompanyStatusRequest` | `get_status_company` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_status) |
| `$liqpay->pos()->receiversStatus()` | `PosReceiversStatusRequest` | `get_status_receivers` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_status) |
| `$liqpay->pos()->waitersStatus()` | `PosWaitersStatusRequest` | `get_status_waiters` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_status) |
| `$liqpay->pos()->tablesStatus()` | `PosTablesStatusRequest` | `get_status_tables` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_status) |
| `$liqpay->pos()->allCompaniesStatus()` | `PosAllCompaniesStatusRequest` | `get_all_status_company` | POST tradingpoints `/trading-points/horeca/api/pos/data` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/venue_status) |
| `$liqpay->pos()->bills()` | `PosBillsRequest` | `get_bills` | POST QR `/api/extcallback` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/order_payment) |
| `$liqpay->pos()->splitBills()` | `PosSplitBillsRequest` | `split_bills` | POST QR `/api/extcallback` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/order_payment) |
| `$liqpay->pos()->refundBill()` | `PosRefundBillRequest` | `refund_bill` | POST QR `/api/extapi/request` (JSON envelope) | [Reference](https://www.liqpay.ua/en/doc/api/POS/order_payment) |

## Scope and protocol notes

- Checkout, widget, donation and authorization builders create signed local data. Their tests verify payloads and signatures without making an HTTP request. Frontend widgets and Apple/Google payment-token collection use LiqPay browser SDKs.
- Splitting is expressed through `splitRules()` on the payment or checkout builder. The current splitting guide defines no additional standalone server endpoint.
- Public exchange-rate endpoints are provided by PrivatBank and receive no merchant credentials. Requests select JSON so their responses remain native PHP arrays.
- POS builders cover messages sent by the POS integration to the bank: venue data, status queries, bill data, split results and refunds. They use separate hosts, JSON envelopes and SHA3-256 without adding merchant `public_key` or API `version` to the signed payload. Bank-to-POS `get_bills`, `pay_bills` and `split_bills` request handling belongs in the application; authenticate those requests with `callback()->verifyPos()`.
- Outbound POS `bills()` and `splitBills()` are responses to bank-initiated requests. They must carry the original `req_id`. `refundBill()` initiates a refund through the documented external API.
- Callback, errors and testing documentation are protocols/reference data, not extra outbound payment endpoints.
- Field names and conditional requirements sometimes conflict in the published tables. The SDK checks core required fields and documented funding alternatives; merchant eligibility, payment-network rules and remaining conditional constraints are enforced by LiqPay. It does not invent new actions or silently infer signatures for unknown API versions.
- API behavior has been verified through documentation and mock HTTP tests. No live merchant transaction has been exercised.

The machine-readable inventory in `operations.json` records each class, factory path, action, endpoint, documented fields and validation groups. It is a maintenance reference; runtime dispatch uses concrete classes.
