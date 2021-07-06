<?php

namespace App\Services\Faqs;

use App\Entity\Faq\Faq;
use Illuminate\Support\Facades\Cache;

class FaqsService
{
    /**
     * @param mixed $slug
     * @return mixed
     */
    public function find($slug)
    {
        return Cache::tags(Faq::class)->rememberForever('faq_'.$slug, function () use ($slug) {
            return Faq::with('translations')
                ->where('slug', $slug)
                ->orWhere('id', $slug)
                ->firstOrFail();
        });
    }

    public function update(Faq $faq, array $data)
    {
        $translations = [];
        if(isset($data['content'])) {
            foreach ($data['content'] as $locale => $value) {
                $translations[$locale] = [
                    'content' => $value
                ];
            }
        }
        return $faq->fill($translations)->save();
    }

    public function getAll()
    {
        return Cache::tags(Faq::class)->rememberForever('faqs_all', function () {
            return Faq::with('translations')->get();
        });
    }

}
