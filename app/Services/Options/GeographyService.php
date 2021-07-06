<?php

namespace App\Services\Options;

use App\Entity\Options\Geography\Geography;
use Illuminate\Support\Facades\Cache;

class GeographyService
{
    public function findBySlug($slug): Geography
    {
        return Cache::tags(Geography::class)->remember('geography_slug_'.$slug, 30, function () use ($slug) {
            return Geography::with('translations')
                ->where('slug', $slug)
                ->firstOrFail();
        });
    }
}
