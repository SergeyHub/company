<?php

namespace Tests\Unit;

use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class Test extends TestCase
{

    use RefreshDatabase;

    public function test_country_translates()
    {
        $country = factory(Country::class)->create();
        App::setLocale('en');
        $this->assertEquals($country->name, $country->translate('en')->name);
    }

    public function test_city_translates()
    {
        $country = factory(Country::class)->create();
        $city = factory(City::class)->create([
            'country_id' => $country->id
        ]);
        App::setLocale('en');
        $this->assertEquals($city->name, $city->translate('en')->name);
    }

}
