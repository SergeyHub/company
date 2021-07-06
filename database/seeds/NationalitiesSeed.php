<?php

use Illuminate\Database\Seeder;

class NationalitiesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = file_get_contents(__DIR__ . '/data/nationalities.json');
        $nationalities = json_decode($data, true);

        foreach ($nationalities as $nationality) {
            $name_ru_exploded = explode(',', $nationality['RUSTEXT']);
            \App\Entity\Options\Nationality\Nationality::create([
                'ru' => [
                    'name' =>  \Illuminate\Support\Str::ucfirst(end($name_ru_exploded))
                ],
                'en' => [
                    'name' => $nationality['ENGTEXT']
                ]
            ]);
        }
    }
}
