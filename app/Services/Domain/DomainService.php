<?php

namespace App\Services\Domain;

use App\Services\Geo\CountryService;
use Illuminate\Support\Facades\Cache;

class DomainService {

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function setEnvForCountry($country_slug)
    {
        $country = $this->countryService->findBySlug($country_slug);
        // выставляем конфиг страны
        config(['domain.country' => $country]);
    }

}
