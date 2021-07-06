<?php

namespace App\Console\Commands;

use App\Entity\Geo\City\CityTranslation;
use App\Entity\Geo\Country\CountryTranslation;
use Illuminate\Console\Command;

class FillCountriesPrepositionalNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:prepositional';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $translations = CountryTranslation::where('locale', 'ru')->get();
        foreach ($translations as $translation) {
            if ($this->firstCharIsRussian($translation->name)) {
                $padegs = $this->getNamePadegs($translation->name);
                $translation->name_prepositional = $padegs['prepositional'];
                $translation->name_instrumental = $padegs['instrumental'];
                $translation->name_accusative = $padegs['accusative'];
                $translation->name_dative = $padegs['dative'];
                $translation->name_genitive = $padegs['genitive'];
                $translation->save();
            }
        }

        $translations = CityTranslation::where('locale', 'ru')->get();
        foreach ($translations as $translation) {
            if ($this->firstCharIsRussian($translation->name)) {
                $padegs = $this->getNamePadegs($translation->name);
                $translation->name_prepositional = $padegs['prepositional'];
                $translation->name_instrumental = $padegs['instrumental'];
                $translation->name_accusative = $padegs['accusative'];
                $translation->name_dative = $padegs['dative'];
                $translation->name_genitive = $padegs['genitive'];
                $translation->save();
            }
        }
    }

    public function getNamePadegs(string $name)
    {
        $response = file_get_contents("http://morphos.io/api/inflect-geographical-name?name=".urlencode($name)."&_format=json");
        $response = json_decode($response, true);
        return [
            'genitive' => $response['cases'][1],
            'dative' => $response['cases'][2],
            'accusative' => $response['cases'][3],
            'instrumental' => $response['cases'][4],
            'prepositional' => $response['cases'][5],
        ];
    }

    public function translateToRu(string $name)
    {
        $key = "trnsl.1.1.20200121T043524Z.1db3a974234c97aa.e9629f80532f6682a3f3f455cd369261e5067c83";
        $url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=".$key."&text=".urlencode($name)."&lang=ru";
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        $translate = $response['text'][0];
        return $translate;
    }

    public function firstCharIsRussian($text) {
        return preg_match('/[А-Яа-яЁё]/u', substr($text, 0, 2));
    }

}
