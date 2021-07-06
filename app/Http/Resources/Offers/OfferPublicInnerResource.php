<?php

namespace App\Http\Resources\Offers;

use App\Http\Resources\Clients\ClientPublicResource;
use App\Http\Resources\Geo\CityGirlProfileResource;
use App\Http\Resources\Geo\CityResource;
use App\Http\Resources\Geo\CountryGirlProfileResource;
use App\Http\Resources\Geo\CountryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferPublicInnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'country' => new CountryGirlProfileResource($this->country),
            'city' => new CityGirlProfileResource($this->city),
            'has_access' => false,
            'client' => $this->client ? new ClientPublicResource($this->client) : null,
            'cost' => $this->cost,
        ];
    }
}
