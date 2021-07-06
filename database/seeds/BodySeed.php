<?php

use Illuminate\Database\Seeder;

class BodySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/body.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\Body\Body::create([
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
