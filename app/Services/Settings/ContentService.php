<?php

namespace App\Services\Settings;

use App\Entity\Content\Content;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    /**
     * @param mixed $slug
     * @return mixed
     */
    public function find($slug)
    {
        return Cache::tags(Content::class)->rememberForever('content_'.$slug, function () use ($slug) {
            return Content::with('translations')
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();
        });
    }

    public function update(Content $content, array $data)
    {
        $translations = [];
        if(isset($data['content'])) {
            foreach ($data['content'] as $locale => $value) {
                $translations[$locale] = [
                    'content' => $value
                ];
            }
        }
        return $content->fill($translations)->save();
    }

    public function getAll()
    {
        return Cache::tags(Content::class)->rememberForever('contents_all', function () {
            return Content::with('translations')
                ->get();
        });
    }

}
