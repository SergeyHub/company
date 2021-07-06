<?php

use Illuminate\Database\Seeder;

class CurrenciesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = ['RUB', 'EUR', 'USD'];
        foreach ($currencies as $currency)
            \App\Entity\Bill\Currency::create([
                'title' => $currency
            ]);
    }
}
