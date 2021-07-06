<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientPublicResource extends JsonResource
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
            'phone' => $this->phone,
            'age' => $this->age,
            'city' => $this->city_id ? $this->city->name : null,
            'country' => $this->country_id ? $this->country->name : null,
            'nationality' => $this->nationality_id ? $this->nationality->name : null,
            'about' => $this->about,
            'user_id' => $this->user_id,
        ];
    }
}
