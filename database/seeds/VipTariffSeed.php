<?php

use Illuminate\Database\Seeder;

class VipTariffSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Tariffs\VipTariff::create([
            'month_cost' => 10,
            'year_cost' => 100,
            'ru' => [
                'name' => 'VIP',
                'description' => ''
            ],
            'en' => [
                'name' => 'VIP',
                'description' => ''
            ]
        ]);
    }
}
