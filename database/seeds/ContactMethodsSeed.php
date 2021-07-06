<?php

use Illuminate\Database\Seeder;

class ContactMethodsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Entity\Options\ContactMethod\ContactMethod::create([
            'en' => [
                'name' => 'Whatsapp'
            ],
            'ru' => [
                'name' => 'Whatsapp'
            ]
        ]);
        \App\Entity\Options\ContactMethod\ContactMethod::create([
            'en' => [
                'name' => 'SMS'
            ],
            'ru' => [
                'name' => 'SMS'
            ]
        ]);
        \App\Entity\Options\ContactMethod\ContactMethod::create([
            'en' => [
                'name' => 'Calls'
            ],
            'ru' => [
                'name' => 'Звонки'
            ]
        ]);
    }
}
