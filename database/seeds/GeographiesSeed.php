<?php

use Illuminate\Database\Seeder;

class GeographiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = file_get_contents(__DIR__.'/data/geographies.json');
        $geographies = json_decode($data, true);

        foreach ($geographies as $row) {
            \App\Entity\Options\Geography\Geography::create([
                'en' => [
                    'name' => $row['en']
                ],
                'ru' => [
                    'name' => $row['ru']
                ],
                'slug' => $row['slug']
            ]);
        }
    }
}
