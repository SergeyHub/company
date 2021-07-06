<?php

namespace App\Services\Geo;

use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Http\Requests\Cities\CreateRequest;
use App\Http\Requests\Cities\UpdateRequest;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Boolean;

class CityService
{

    protected $city;
    protected $countryService;

    public function __construct(City $city, CountryService $countryService)
    {
        $this->city = $city;
        $this->countryService = $countryService;
    }

    public function create($name, $slug, $countryId): City
    {
        $country = $this->countryService->find($countryId);
        $city = $this->city->make([
            'name' => $name,
            'slug' => $slug
        ]);
        $city->country()->associate($country);
        $city->saveOrFail();

        Cache::tags(City::class)->put('city_'.$city->id, $city, 30);
        return $city;
    }

    public function createFromRequest(CreateRequest $request): City
    {
        $city = $this->city->create($request->all());
        Cache::tags(City::class)->put('city_'.$city->id, $city, 30);
        return $city;
    }

    public function updateFromRequest(UpdateRequest $request, $id): bool
    {
        $city = $this->city->findOrFail($id);
        $status = $city->update($request->all());
        if($status) {
            Cache::tags(City::class)->put('city_' . $city->id, $city, 30);
        }
        return $status;
    }

    public function getCitiesForCountry($countryId)
    {
        return Cache::tags(City::class)->remember('country_cities_'.$countryId, 30, function () use ($countryId) {
            return City::with('translations')
                ->active()
                ->where('country_id', $countryId)
                ->get();
        });
    }

    public function find($id)
    {
        return Cache::tags(City::class)->remember('city_'.$id, 30, function () use ($id) {
            return City::with('translations')->active()->findOrFail($id);
        });
    }

    public function findBySlug($slug)
    {
        return Cache::tags(City::class)->remember('city_'.$slug, 30, function () use ($slug) {
            return City::with('translations')
                ->active()
                ->where('slug', $slug)
                ->firstOrFail();
        });
    }

}
