<?php

use Illuminate\Database\Seeder;

class EyesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Коричневый',
            ],
            'en' => [
                'name' => 'Brown',
            ]
        ]);
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Голубой',
            ],
            'en' => [
                'name' => 'Blue',
            ]
        ]);
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Зеленый',
            ],
            'en' => [
                'name' => 'Green',
            ]
        ]);
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Карий',
            ],
            'en' => [
                'name' => 'Hazel',
            ]
        ]);
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Серый',
            ],
            'en' => [
                'name' => 'Grey',
            ]
        ]);
        \App\Entity\Options\Eye\Eye::create([
            'ru' => [
                'name' => 'Другой',
            ],
            'en' => [
                'name' => 'Other',
            ]
        ]);
    }
}
