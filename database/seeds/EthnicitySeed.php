<?php

use Illuminate\Database\Seeder;

class EthnicitySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/ethnicity.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\Ethnicity\Ethnicity::create([
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
