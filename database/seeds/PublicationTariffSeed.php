<?php

use Illuminate\Database\Seeder;

class PublicationTariffSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Tariffs\PublicationTariff::create([
            'cost' => 10,
            'days' => 10,
            'ru' => [
                'name' => '10 дней'
            ],
            'en' => [
                'name' => '10 days'
            ]
        ]);
        \App\Entity\Tariffs\PublicationTariff::create([
            'cost' => 20,
            'days' => 20,
            'ru' => [
                'name' => '20 дней'
            ],
            'en' => [
                'name' => '20 days'
            ]
        ]);
        \App\Entity\Tariffs\PublicationTariff::create([
            'cost' => 25,
            'days' => 30,
            'ru' => [
                'name' => '30 дней'
            ],
            'en' => [
                'name' => '30 days'
            ]
        ]);
    }
}
