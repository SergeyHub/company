<?php

namespace App\Http\Resources\Geo;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'name_prepositional' => $this->name_prepositional,
            'name_genitive' => $this->name_genitive,
            'name_instrumental' => $this->name_instrumental,
            'name_accusative' => $this->name_accusative,
            'name_dative' => $this->name_dative,
            'slug' => $this->slug,
            'girls_count' => $this->girls_count,
        ];
    }

}
