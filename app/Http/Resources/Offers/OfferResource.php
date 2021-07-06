<?php

namespace App\Http\Resources\Offers;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $locales = config('translatable.locales');

        $localize_attr = function (string $attr_name, $obj) use ($locales) {
            $translations = $obj->getTranslationsArray();
            $attr_translations = [];
            foreach ($locales as $locale) {
                $attr_translations[$locale] = isset($translations[$locale][$attr_name])
                    ? $translations[$locale][$attr_name] : null;
            }
            return $attr_translations;
        };

        return [
            'id' => $this->id,
            'name' => $localize_attr('name', $this),
            'content' => $localize_attr('content', $this),
            'created_at' => $this->created_at,
            'country' => $this->country_id,
            'city' => $this->city_id,
            'status' => $this->status,
            'cost' => $this->cost,
            'client_id' => $this->client_id
        ];
    }
}
