<?php

use Illuminate\Database\Seeder;

class ReadyForSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $data = file_get_contents(__DIR__.'/data/ready_for.json');
        $languages = json_decode($data, true);

        foreach ($languages as $row) {
            \App\Entity\Options\ReadyFor\ReadyFor::create([
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
