<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentAdminResource extends JsonResource
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
            'slug' => $this->slug,
            'content' => $localize_attr('content', $this),
        ];
    }
}
