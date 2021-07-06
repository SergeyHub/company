<?php

namespace App\Console\Commands;

use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Services\Geo\CountryService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class UpdateCountriesStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $countryService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CountryService $countryService)
    {
        parent::__construct();
        $this->countryService = $countryService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // очищаем кеш
        Cache::forget('all_countries_cities');
        Cache::forget('all_countries');
        Cache::forget('top_countries_5');
        Cache::tags(City::class)->flush();
        Cache::tags(Country::class)->flush();

        // обновляем кеш
        $this->countryService->getAllCountriesWithCities();
        $this->countryService->getAllCountries();
        $this->countryService->topCountries();
    }
}
