<?php

use Illuminate\Database\Seeder;

class HairsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Options\Hair\Hair::create([
            'ru' => [
                'name' => 'Коричневый',
            ],
            'en' => [
                'name' => 'Brown',
            ]
        ]);
        \App\Entity\Options\Hair\Hair::create([
            'ru' => [
                'name' => 'Черный',
            ],
            'en' => [
                'name' => 'Black',
            ]
        ]);
        \App\Entity\Options\Hair\Hair::create([
            'ru' => [
                'name' => 'Блондинка',
            ],
            'en' => [
                'name' => 'Blonde',
            ]
        ]);
        \App\Entity\Options\Hair\Hair::create([
            'ru' => [
                'name' => 'Красный',
            ],
            'en' => [
                'name' => 'Red',
            ]
        ]);
        \App\Entity\Options\Hair\Hair::create([
            'ru' => [
                'name' => 'Другой',
            ],
            'en' => [
                'name' => 'Other',
            ]
        ]);
    }
}
