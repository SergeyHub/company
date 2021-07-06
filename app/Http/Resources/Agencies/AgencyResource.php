<?php

namespace App\Http\Resources\Agencies;

use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
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
            'status' => $this->status,
            'description' => $localize_attr('description', $this),
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'contact_methods' => $this->contactMethods->pluck('id'),
            'geographies' => $this->geographies,
            'countries' => $this->countries,
            'profile_site' => $this->profileSite ? $this->profileSite->url : null
        ];
    }
}
