<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entity\Girl\Girl;


class CheckVipExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vip:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set girls on expired vip';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $girls = Girl::where('vip_end_date', '<=', now())->get();
        $girls->each(function($girl) {
            $girl->removeVip();
            $girl->save();
        });
    }
}
