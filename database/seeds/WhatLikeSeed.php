<?php

use Illuminate\Database\Seeder;

class WhatLikeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/what_like.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\WhatLike\WhatLike::create([
                'en' => [
                    'name' => $row['en']
                ],
                'ru' => [
                    'name' => $row['ru']
                ]
            ]);
        }
    }
}
