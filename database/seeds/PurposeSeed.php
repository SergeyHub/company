<?php

use Illuminate\Database\Seeder;

class PurposeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Options\Purpose\Purpose::create([
            'en' => [
                'name' => 'Dating by calculation'
            ],
            'ru' => [
                'name' => 'Отношения по расчету'
            ]
        ]);
        \App\Entity\Options\Purpose\Purpose::create([
            'en' => [
                'name' => 'Permanent relationship'
            ],
            'ru' => [
                'name' => 'Постоянные отношения'
            ]
        ]);
        \App\Entity\Options\Purpose\Purpose::create([
            'en' => [
                'name' => 'Online chat'
            ],
            'ru' => [
                'name' => 'Онлайн-общение'
            ]
        ]);
    }
}
