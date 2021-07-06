<?php

namespace App\Console\Commands;

use App\Jobs\CheckPaymentsJob;
use App\Services\Bills\BillService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use YandexMoney\API;

class CheckPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $billService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(BillService $billService)
    {
        parent::__construct();
        $this->billService = $billService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch((new CheckPaymentsJob)->delay(5));
        dispatch((new CheckPaymentsJob)->delay(10));
        dispatch((new CheckPaymentsJob)->delay(20));
        dispatch((new CheckPaymentsJob)->delay(30));
        dispatch((new CheckPaymentsJob)->delay(40));
        dispatch((new CheckPaymentsJob)->delay(50));
    }

}
