<?php

namespace App\Http\Resources\Agencies;

use App\Http\Resources\Girls\GirlPublicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AgencyPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $girls = $this->publishedGirls->take(4);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_image' => $this->phone_image,
            'description' => $this->description,
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'profile_site' => $this->profileActiveSite,
            'contact_methods' => $this->contactMethods->pluck('name'),
            'geographies' => $this->geographies->pluck('name'),
            'countries' => $this->countries->pluck('name'),
            'girls' => GirlPublicResource::collection($girls)
        ];
    }
}
