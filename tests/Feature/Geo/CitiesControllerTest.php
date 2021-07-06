<?php

namespace Tests\Feature\Geo;

use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\User\User;
use App\Http\Resources\CountryResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CitiesControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testIndex()
    {
        $country = factory(Country::class)->create();
        $city = factory(City::class)->create(['country_id' => $country->id]);
        $response = $this->get('/api/cities?country_id='.$country->id)->json();
        $this->assertNotEmpty($response['data']);
        $this->assertEquals($city->id, $response['data'][0]['id']);
    }

    public function testShow()
    {
        $country = factory(Country::class)->create();
        $city = factory(City::class)->create([
            'status' => 1,
            'country_id' => $country->id
        ]);
        $response = $this->get('/api/cities/'.$city->id)->json();
        $this->assertNotEmpty($response['data']);
        $this->assertEquals($city->id, $response['data']['id']);
    }

    public function testStore()
    {
        $country = factory(Country::class)->create();
        $response = $this->json('POST', '/api/cities', [
            'slug' => 'moscow',
            'ru' => ['name' => 'Москва'],
            'en' => ['name' => 'Moscow'],
            'country_id' => $country->id
        ])->json();
        $this->assertEquals('moscow', $response['data']['slug']);
    }

    public function testUpdate()
    {
        $country = factory(Country::class)->create();
        $city = factory(City::class)->create(['country_id' => $country->id]);

        $user = factory(User::class)->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($user, 'api')
            ->json('PUT', '/api/cities/'.$city->id, [
                'slug' => 'moscow_two'
            ]);
    }

    public function testDestroy()
    {

    }

}
