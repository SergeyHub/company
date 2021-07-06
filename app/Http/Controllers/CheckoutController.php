<?php

namespace App\Http\Controllers;

use App\Services\Bills\BillService;
use Illuminate\Http\Request;
use App\Services\PaymentGateways\BtcService;

class CheckoutController extends Controller
{

    private $billService;
    private $btcService;

    public function __construct(BillService $billService, BtcService $btcService)
    {
        $this->billService = $billService;
        $this->btcService = $btcService;
    }

    public function yandex(Request $request)
    {
        if(!$request->has('label'))
            return 'BAD';

        $bill = $this->billService->findActiveBill($request->get('label'));
        if(!$bill)
            return 'BAD';

        // выставляем оплату
        $this->billService->setPaid($bill);

        return 'OK';
    }

    public function btc(Request $request)
    {
        $invoiceId = $request->get('invoiceId');

        if($request->type == 'InvoiceReceivedPayment') {
            $invoiceInfo = $this->btcService->getInvoiceInfo($invoiceId);

            $billId = $invoiceInfo->meta->bill_id;

            \Log::info(json_encode($invoiceInfo));

            $bill = $this->billService->findActiveBill($billId);
            $this->billService->setPaid($bill);
        }

        return 'OK';
    }
}
