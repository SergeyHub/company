<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Girls\GirlPublicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminReviewsResource extends JsonResource
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
            'review' => $localize_attr('review', $this),
            'nickname' => $this->nickname,
            'email' => $this->email,
            //'meeting_date' => $this->meeting_date ? $this->meeting_date->format('d.m.Y') : null,
            //'meeting_city' => $localize_attr('meeting_city', $this),
            //'duration_type' => $this->duration_type,
            //'duration' => $this->duration,
            //'price' => $this->price,
            //'country' => $this->country->id,
            //'currency' => $this->currency->id,
            'created_at' => $this->created_at,
            'girl' => new GirlPublicResource($this->model),
            'model_id' => $this->model_id,
            'published' => $this->published
        ];
    }
}
