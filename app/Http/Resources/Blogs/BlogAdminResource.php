<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogAdminResource extends JsonResource
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
            'title' => $localize_attr('title', $this),
            'short_description' => $localize_attr('short_description', $this),
            'active' => $this->active,
            'cover' => $this->cover ? $this->cover->getUrl('thumbs') : null,
            'created_at' => $this->created_at
        ];
    }
}
