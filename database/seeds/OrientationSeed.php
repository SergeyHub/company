<?php

use Illuminate\Database\Seeder;

class OrientationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/orientation.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\Orientation\Orientation::create([
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
