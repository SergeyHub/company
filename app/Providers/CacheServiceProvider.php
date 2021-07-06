<?php

namespace App\Providers;

use App\Entity\Bill\Currency;
use App\Entity\Blog\Blog;
use App\Entity\Content\Content;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\ContactMethod\ContactMethod;
use App\Entity\Options\Eye\Eye;
use App\Entity\Options\Hair\Hair;
use App\Entity\Options\Language\Language;
use App\Entity\Options\Nationality\Nationality;
use App\Entity\Options\Purpose\Purpose;
use App\Entity\Tariffs\PublicationTariff;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    private $classes = [
        City::class,
        Country::class,
        Hair::class,
        Eye::class,
        Nationality::class,
        Currency::class,
        ContactMethod::class,
        Language::class,
        Purpose::class,
        Content::class,
        PublicationTariff::class,
        Content::class,
        Blog::class,
    ];

    public function boot(): void
    {
        foreach ($this->classes as $class) {
            $this->registerFlusher($class);
        }
    }

    private function registerFlusher($class): void
    {
        $flush = function() use ($class) {
            Cache::tags($class)->flush();
        };

        /** @var Model $class */
        $class::created($flush);
        $class::saved($flush);
        $class::updated($flush);
        $class::deleted($flush);
    }
}
