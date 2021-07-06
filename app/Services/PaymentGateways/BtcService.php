<?php
namespace App\Services\PaymentGateways;

use \GuzzleHttp\Client;
use App\Entity\Bill\Bill;

class BtcService {
    protected $client;

    public function __construct() {
        $this->client = new Client;
    }

    public function getPaymentLink(Bill $bill) {
        $response = $this->post('/invoices', [
            "amount" => $bill->amount,
            "currency" => 'USD',
            "metadata" => [
                "orderId" => $bill->id,
            ],
            "checkout" => [
                "speedPolicy" => "HighSpeed",
                "expirationMinutes" => 30,
                "monitoringMinutes" => 30,
                "paymentTolerance" =>  0,
                "redirectURL" => "https://". config('app.url') ."/profile",
                "defaultLanguage" => "en",
            ],
        ]);

        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);

        return 'https://master-pay-bitcoin.com/i/' . $response['id'];
    }

    public function getInvoiceInfo($invoiceId) {
        $response = $this->get('/invoices/'. $invoiceId);

        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);

        return $response;

    }

    public function __call($name, $arguments) {
        $url = 'https://master-pay-bitcoin.com/api/v1/stores/'. config('payment_gateways.btc_store_id') . $arguments[0];

        $params = $arguments[1] ?? [];

        $response = $this->client->{$name}($url, [
            'json' => $params,
            'headers' => [
                'Authorization' => 'token ' . config('payment_gateways.btc_token'),
            ],
        ]);

        return $response;
    }

}
