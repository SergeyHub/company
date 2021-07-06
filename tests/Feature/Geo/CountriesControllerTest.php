<?php

namespace Tests\Feature\Geo;

use App\Entity\Geo\Country\Country;
use App\Http\Resources\CountryResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountriesControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testIndex()
    {
        $country = factory(Country::class)->create();
        $response = $this->get('/api/countries')->json();
        $this->assertNotEmpty($response['data']);
        $this->assertEquals($country->id, $response['data'][0]['id']);
    }

    public function testShow()
    {
        $country = factory(Country::class)->create(['status' => 1]);
        $response = $this->get('/api/countries/'.$country->id)->json();
        $this->assertNotEmpty($response['data']);
        $this->assertEquals($country->id, $response['data']['id']);
    }

    public function testStore()
    {
        $response = $this->post('/api/countries', [
            'slug' => 'moscow',
            'ru' => ['name' => 'Россия'],
            'en' => ['name' => 'Russia']
        ])->json();
        $this->assertEquals('russia', $response['data']['slug']);
    }

    public function testUpdate()
    {

    }

    public function testDestroy()
    {

    }

}
