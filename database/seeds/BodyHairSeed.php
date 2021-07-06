<?php

use Illuminate\Database\Seeder;

class BodyHairSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/body_hair.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\BodyHair\BodyHair::create([
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
