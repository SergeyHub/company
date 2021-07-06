<?php

namespace App\Jobs;

use App\Services\Bills\BillService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use YandexMoney\API;

class CheckPaymentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $billService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->billService = new BillService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new API('41001844143583.512D6D9A32661DE157443677F99F8FB53DF64BE89174C6350CF677B42FD275D20343BC9DA631D6CE98D910B565BE8692D8170E4D9D76EA2D65DC47BEA8F5FF5732701389E39D4B679DE8D6E1CA62AE67FDE7AD2F12092A5D991D5B6757799B68F8DD732EE85AF1EE7A68AAE968C0CBC7EEE4366D9CDA3B6A443D7AA7468162EE');
        $operations_data = $api->operationHistory(array(
            "records" => 10,
            "type" => "deposition",
        ));

        $operations = $operations_data->operations;

        foreach ($operations as $operation) {
            if(isset($operation->label)) {
                $this->processPayment($operation);
            }
        }
    }

    public function processPayment($operation)
    {
        $bill = $this->billService->findActiveBill($operation->label);
        if(!$bill)
            return;
        // выставляем оплату
        $this->billService->setPaid($bill);
    }
}
