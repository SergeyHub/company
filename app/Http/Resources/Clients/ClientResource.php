<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'phone' => $this->phone,
            'age' => $this->age,
            'city' => $this->city_id,
            'country' => $this->country_id,
            'nationality' => $this->nationality_id,
            'about' => $localize_attr('about', $this),
            'user_id' => $this->user_id,
        ];
    }
}
