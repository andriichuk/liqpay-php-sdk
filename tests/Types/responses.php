<?php

declare(strict_types=1);

namespace Andriichuk\LiqPay\Tests\Types;

use Andriichuk\LiqPay\LiqPay;

use function PHPStan\Testing\assertType;

// Static-only fixtures: PHPStan checks these bodies; they never send live requests.

function refundResponse(LiqPay $client): void
{
    $response = $client->refund()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('int|numeric-string|null', $response['payment_id'] ?? null);
    assertType("'false'|'true'|bool|null", $response['wait_amount'] ?? null);
}

function paymentResponse(LiqPay $client): void
{
    $response = $client->payment()->send();
    assertType('string|null', $response['result'] ?? null);
}

function checkoutResponse(LiqPay $client): void
{
    $response = $client->checkout()->send();
    assertType('string', $response['url']);
    assertType('string', $response['data']);
    assertType('string', $response['signature']);
}

function widgetResponse(LiqPay $client): void
{
    $response = $client->widget()->send();
    assertType('string', $response['url']);
    assertType('string', $response['data']);
    assertType('string', $response['signature']);
}

function donationResponse(LiqPay $client): void
{
    $response = $client->donation()->send();
    assertType('string', $response['url']);
    assertType('string', $response['data']);
    assertType('string', $response['signature']);
}

function authorizationResponse(LiqPay $client): void
{
    $response = $client->authorization()->send();
    assertType('string', $response['url']);
    assertType('string', $response['data']);
    assertType('string', $response['signature']);
}

function privatPayResponse(LiqPay $client): void
{
    $response = $client->privatPay()->send();
    assertType('string|null', $response['result'] ?? null);
}

function applePayResponse(LiqPay $client): void
{
    $response = $client->applePay()->send();
    assertType('string|null', $response['result'] ?? null);
}

function googlePayResponse(LiqPay $client): void
{
    $response = $client->googlePay()->send();
    assertType('string|null', $response['result'] ?? null);
}

function tokenPaymentResponse(LiqPay $client): void
{
    $response = $client->tokenPayment()->send();
    assertType('string|null', $response['result'] ?? null);
}

function cashResponse(LiqPay $client): void
{
    $response = $client->cash()->send();
    assertType('string|null', $response['result'] ?? null);
}

function qrResponse(LiqPay $client): void
{
    $response = $client->qr()->send();
    assertType('string|null', $response['result'] ?? null);
}

function staticQrResponse(LiqPay $client): void
{
    $response = $client->staticQr()->send();
    assertType('string|null', $response['result'] ?? null);
}

function holdResponse(LiqPay $client): void
{
    $response = $client->hold()->send();
    assertType('string|null', $response['result'] ?? null);
}

function captureResponse(LiqPay $client): void
{
    $response = $client->capture()->send();
    assertType('string|null', $response['result'] ?? null);
}

function dccResponse(LiqPay $client): void
{
    $response = $client->dcc()->send();
    if (isset($response['dcc_allowed'][0])) {
        assertType('float|int|numeric-string|null', $response['dcc_allowed'][0]['amount'] ?? null);
    }
    assertType('string|null', $response['result'] ?? null);
}

function subscriptionCreateResponse(LiqPay $client): void
{
    $response = $client->subscriptions()->create()->send();
    assertType('string|null', $response['result'] ?? null);
}

function subscriptionCancelResponse(LiqPay $client): void
{
    $response = $client->subscriptions()->cancel()->send();
    assertType('string|null', $response['result'] ?? null);
}

function subscriptionUpdateResponse(LiqPay $client): void
{
    $response = $client->subscriptions()->update()->send();
    assertType('string|null', $response['result'] ?? null);
}

function invoiceCreateResponse(LiqPay $client): void
{
    $response = $client->invoices()->create()->send();
    assertType('string|null', $response['result'] ?? null);
}

function invoiceCancelResponse(LiqPay $client): void
{
    $response = $client->invoices()->cancel()->send();
    assertType('string|null', $response['result'] ?? null);
}

function invoiceUnitsResponse(LiqPay $client): void
{
    $response = $client->invoices()->units()->send();
    if (isset($response[0])) {
        assertType('int|numeric-string|null', $response[0]['id'] ?? null);
        assertType('string|null', $response[0]['full_name_en'] ?? null);
    }
}

function tokenCreateResponse(LiqPay $client): void
{
    $response = $client->tokens()->create()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('string|null', $response['card_token_info']['tokenRef'] ?? null);
}

function tokenCreateUniqueResponse(LiqPay $client): void
{
    $response = $client->tokens()->createUnique()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('string|null', $response['card_token_info']['tokenRef'] ?? null);
}

function tokenUpdateResponse(LiqPay $client): void
{
    $response = $client->tokens()->update()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('string|null', $response['card_token_info']['tokenRef'] ?? null);
}

function confirm3dsResponse(LiqPay $client): void
{
    $response = $client->confirmations()->threeDs()->send();
    assertType('string|null', $response['result'] ?? null);
}

function confirmCvvResponse(LiqPay $client): void
{
    $response = $client->confirmations()->cvv()->send();
    assertType('string|null', $response['result'] ?? null);
}

function confirmOtpResponse(LiqPay $client): void
{
    $response = $client->confirmations()->otp()->send();
    assertType('string|null', $response['result'] ?? null);
}

function statusResponse(LiqPay $client): void
{
    $response = $client->information()->status()->send();
    assertType('string|null', $response['result'] ?? null);
}

function paymentDataResponse(LiqPay $client): void
{
    $response = $client->information()->data()->send();
    assertType('string|null', $response['result'] ?? null);
}

function receiptResponse(LiqPay $client): void
{
    $response = $client->information()->receipt()->send();
    assertType('string|null', $response['result'] ?? null);
}

function reportsResponse(LiqPay $client): void
{
    $response = $client->information()->reports()->send();
    if (is_array($response)) {
        assertType('int|numeric-string|null', $response['data'][0]['payment_id'] ?? null);
    } else {
        assertType('string', $response);
    }
}

function compensationResponse(LiqPay $client): void
{
    $response = $client->information()->compensation()->send();
    if (is_array($response)) {
        assertType('int|numeric-string|null', $response['data'][0]['compensation_id'] ?? null);
    } else {
        assertType('string', $response);
    }
}

function registerResponse(LiqPay $client): void
{
    $response = $client->information()->register()->send();
    if (is_array($response)) {
        assertType('float|int|numeric-string|null', $response['data'][0]['trans_amount'] ?? null);
    } else {
        assertType('string', $response);
    }
}

function compensationFileResponse(LiqPay $client): void
{
    $response = $client->information()->compensationFile()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('int|string|null', $response['register_token'] ?? null);
}

function compensationFileStatusResponse(LiqPay $client): void
{
    $response = $client->information()->compensationFileStatus()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('string|null', $response['filelink'] ?? null);
}

function transferToCardResponse(LiqPay $client): void
{
    $response = $client->transfers()->toCard()->send();
    assertType('string|null', $response['result'] ?? null);
}

function transferToAccountResponse(LiqPay $client): void
{
    $response = $client->transfers()->toAccount()->send();
    assertType('string|null', $response['result'] ?? null);
}

function merchantCreateResponse(LiqPay $client): void
{
    $response = $client->partnerships()->createMerchant()->send();
    assertType('string|null', $response['result'] ?? null);
}

function merchantRegisterResponse(LiqPay $client): void
{
    $response = $client->partnerships()->registerMerchant()->send();
    assertType('string|null', $response['result'] ?? null);
}

function merchantEditResponse(LiqPay $client): void
{
    $response = $client->partnerships()->editMerchant()->send();
    assertType('string|null', $response['result'] ?? null);
}

function merchantInfoResponse(LiqPay $client): void
{
    $response = $client->partnerships()->merchantInfo()->send();
    assertType('string|null', $response['result'] ?? null);
}

function userInfoResponse(LiqPay $client): void
{
    $response = $client->partnerships()->userInfo()->send();
    assertType('string|null', $response['result'] ?? null);
}

function mccCodesResponse(LiqPay $client): void
{
    $response = $client->partnerships()->mccCodes()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType("''|int|numeric-string|null", $response['mcc_codes'][0]['mcc_code'] ?? null);
}

function mccDocumentsResponse(LiqPay $client): void
{
    $response = $client->partnerships()->mccDocuments()->send();
    assertType('string|null', $response['result'] ?? null);
    assertType('int|numeric-string|null', $response['expected_docs'][0]['alt_docs'][0] ?? null);
}

function exchangeRatesResponse(LiqPay $client): void
{
    $response = $client->publicApi()->exchangeRates()->send();
    assertType('string|null', $response[0]['ccy'] ?? null);
    assertType('numeric-string|null', $response[0]['buy'] ?? null);
}

function exchangeArchiveResponse(LiqPay $client): void
{
    $response = $client->publicApi()->exchangeArchive()->send();
    assertType('int|numeric-string|null', $response['baseCurrency'] ?? null);
    assertType('float|int|numeric-string|null', $response['exchangeRate'][0]['saleRateNB'] ?? null);
}

function posReceiversResponse(LiqPay $client): void
{
    $response = $client->pos()->receivers()->send();
    assertType('string', $response['status']);
}

function posWaitersResponse(LiqPay $client): void
{
    $response = $client->pos()->waiters()->send();
    assertType('string', $response['status']);
}

function posTablesResponse(LiqPay $client): void
{
    $response = $client->pos()->tables()->send();
    assertType('string', $response['status']);
}

function posCompanyStatusResponse(LiqPay $client): void
{
    $response = $client->pos()->companyStatus()->send();
    assertType('string', $response['status']);
    assertType('string|null', $response['companies'][0]['status_company'] ?? null);
}

function posReceiversStatusResponse(LiqPay $client): void
{
    $response = $client->pos()->receiversStatus()->send();
    assertType('string', $response['status']);
    assertType('string|null', $response['receivers'][0]['receiver_status'] ?? null);
}

function posWaitersStatusResponse(LiqPay $client): void
{
    $response = $client->pos()->waitersStatus()->send();
    assertType('string', $response['status']);
    assertType('string|null', $response['waiters'][0]['fio'] ?? null);
}

function posTablesStatusResponse(LiqPay $client): void
{
    $response = $client->pos()->tablesStatus()->send();
    assertType('string', $response['status']);
    assertType('string|null', $response['tables'][0]['qr_code'] ?? null);
}

function posAllCompaniesStatusResponse(LiqPay $client): void
{
    $response = $client->pos()->allCompaniesStatus()->send();
    assertType('string', $response['status']);
}

function posBillsResponse(LiqPay $client): void
{
    $response = $client->pos()->bills()->send();
    assertType('string', $response['status']);
}

function posSplitBillsResponse(LiqPay $client): void
{
    $response = $client->pos()->splitBills()->send();
    assertType('string', $response['status']);
}

function posRefundBillResponse(LiqPay $client): void
{
    $response = $client->pos()->refundBill()->send();
    assertType('string', $response['status']);
    assertType('int|numeric-string|null', $response['payments_success'][0]['payment_id'] ?? null);
}

function callbackResponse(LiqPay $client, string $data, string $signature): void
{
    $response = $client->callback()->verify($data, $signature);
    assertType('int|numeric-string|null', $response['payment_id'] ?? null);
    assertType("'false'|'true'|bool|null", $response['is_3ds'] ?? null);
}

function posCallbackResponse(LiqPay $client, string $data, string $signature): void
{
    $response = $client->callback()->verifyPos($data, $signature);
    assertType('float|int|numeric-string|null', $response['bills'][0]['items'][0]['price'] ?? null);
}
