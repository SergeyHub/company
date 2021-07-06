<?php

namespace App\Services\Geo;

use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\Http\Requests\Countries\CreateRequest;
use App\Http\Requests\Countries\UpdateRequest;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Cache;

class CountryService
{

    protected $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function create($name, $slug): Country
    {
        return $this->country->create([
            'name' => $name,
            'slug' => $slug
        ]);
    }

    public function createFromRequest(CreateRequest $request): Country
    {
        $country = $this->country->create($request->all());
        Cache::tags(Country::class)->put('country_'.$country->id, $country);
        return $country;
    }

    public function getAllCountries()
    {
        return Cache::tags(Country::class)->rememberForever('all_countries', function () {
            return Country::with('translations', 'category')
                ->withCount('girls', 'offers')
                ->active()
                ->get();
        });
    }

    public function topCountries(string $section = Girl::TYPE_GIRLS, int $count=5)
    {
        if (in_array($section, Girl::GIRL_TYPES)) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count, $section) {
                return Country::with(['translations', 'category', 'cities' => function ($query) use ($section) {
                    $query->withCount(['girls' => function ($query) use ($section) {
                        $query->where('type', $section);
                    }]);
                }])->withCount(['girls' => function ($query) use ($section) {
                    $query->where('type', $section);
                }, 'offers'])
                    ->active()
                    ->orderBy('girls_count', 'desc')
                    ->limit($count)
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_TOP50) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count) {
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->limit(50)
                            ->orderBy('views', 'desc');
                    }]);
                }])->withCount(['girls' => function ($query) {
                    $query->limit(50)
                        ->orderBy('views', 'desc');
                }, 'offers'])
                    ->active()
                    ->orderBy('girls_count', 'desc')
                    ->limit($count)
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_VIP) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count) {
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('vip', 1);
                    }]);
                }])->withCount(['girls' => function ($query) {
                    $query->where('vip', 1);
                }, 'offers'])
                    ->active()
                    ->orderBy('girls_count', 'desc')
                    ->limit($count)
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_PORNSTARS) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count) {
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('pornstar', 1);
                    }]);
                }])->withCount(['girls' => function ($query) {
                    $query->where('pornstar', 1);
                }, 'offers'])
                    ->active()
                    ->orderBy('girls_count', 'desc')
                    ->limit($count)
                    ->get();
                }
            );
        }
        if ($section == Girl::FILTER_SECTION_REVIEWS) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count) {
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->whereHas('reviews',function ($query) {
                            $query->where('published', true);
                        });
                    }]);
                }])->withCount(['girls' => function ($query) {
                    $query->whereHas('reviews',function ($query) {
                        $query->where('published', true);
                    });
                }, 'offers'])
                    ->active()
                    ->orderBy('girls_count', 'desc')
                    ->limit($count)
                    ->get();
            }
            );
        }
        if ($section == Girl::FILTER_SECTION_AGENCIES) {
            return Cache::tags(Country::class)->rememberForever('top_countries_' . $count . '_' . $section, function () use ($count) {
                return Country::with(['translations', 'category'])->withCount(['agencies', 'offers'])
                    ->active()
                    ->orderBy('agencies_count', 'desc')
                    ->limit($count)
                    ->get();
            }
            );
        }
    }

    public function getAllCountriesWithCities(string $section = Girl::TYPE_GIRLS)
    {
        if (in_array($section, Girl::GIRL_TYPES)) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () use ($section) {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category', 'cities' => function ($query) use ($section) {
                    $query->withCount(['girls' => function ($query) use ($section) {
                        $query->where('type', $section);
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) use ($section) {
                    $query->where('type', $section);
                }, 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_TOP50) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->limit(50)
                            ->orderBy('views', 'desc');
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->limit(50)
                        ->orderBy('views', 'desc');
                }, 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_PORNSTARS) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('pornstar', 1);
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->where('pornstar', 1);
                }, 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_VIP) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('vip', 1);
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->where('vip', 1);
                }, 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_REVIEWS) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category', 'cities' => function ($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->whereHas('reviews',function ($query) {
                            $query->where('published', true);
                        });
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->whereHas('reviews',function ($query) {
                        $query->where('published', true);
                    });
                }, 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
        if ($section == Girl::FILTER_SECTION_AGENCIES) {
            return Cache::tags(Country::class)->rememberForever('all_countries_cities_' . $section, function () {
                $translationTable = 'country_translations';
                $locale = app()->getLocale();
                return Country::with(['translations', 'category'])->withCount(['agencies', 'offers'])
                    ->join($translationTable, function (JoinClause $join) use ($translationTable, $locale) {
                        $join->on($translationTable . '.country_id', '=', 'countries.id')
                            ->where($translationTable . '.locale', $locale);
                    })
                    ->orderBy($translationTable . '.name', 'asc')
                    ->active()
                    ->get();
            });
        }
    }

    public function updateFromRequest(UpdateRequest $request, $id): bool
    {
        $country = $this->country->findOrFail($id);
        $status = $country->update($request->all());
        Cache::tags(Country::class)->put('country_'.$country->id, $country);
        return $status;
    }

    public function find($id): Country
    {
        return Cache::tags(Country::class)->remember('country_'.$id, 30, function () use ($id) {
            return Country::with(['translations', 'category', 'cities' => function($query) {
                $query->withCount('girls');
            }])->withCount('girls', 'offers')
                ->active()
                ->findOrFail($id);
        });
    }

    public function findBySlug($slug, $section = Girl::TYPE_GIRLS): Country
    {
        if (in_array($section, Girl::GIRL_TYPES)) {
            return Cache::tags(Country::class)->remember('country_slug_'.$slug. '_'.$section, 30, function () use ($slug, $section) {
                return Country::with(['translations', 'category', 'cities' => function($query) use ($section) {
                    $query->withCount(['girls' => function ($query) use ($section) {
                        $query->where('type', $section);
                    }]);
                }])->withCount(['girls' => function ($query) use ($section) {
                    $query->where('type', $section);
                }, 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
        if ($section == Girl::FILTER_SECTION_TOP50) {
            return Cache::tags(Country::class)->remember('country_slug_'.$slug. '_'.$section, 30, function () use ($slug) {
                return Country::with(['translations', 'category', 'cities' => function($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->limit(50)
                            ->orderBy('views', 'desc');
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->limit(50)
                        ->orderBy('views', 'desc');
                }, 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
        if ($section == Girl::FILTER_SECTION_VIP) {
            return Cache::tags(Country::class)->remember('country_slug_'.$slug. '_'.$section, 30, function () use ($slug) {
                return Country::with(['translations', 'category', 'cities' => function($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('vip', 1);
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->where('vip', 1);
                }, 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
        if ($section == Girl::FILTER_SECTION_PORNSTARS) {
            return Cache::tags(Country::class)->remember('country_slug_'.$slug. '_'.$section, 30, function () use ($slug) {
                return Country::with(['translations', 'category', 'cities' => function($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->where('pornstar', 1);
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->where('pornstar', 1);
                }, 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
        if ($section == Girl::FILTER_SECTION_REVIEWS) {
            return Cache::tags(Country::class)->remember('country_slug_'.$slug. '_'.$section, 30, function () use ($slug) {
                return Country::with(['translations', 'category', 'cities' => function($query) {
                    $query->withCount(['girls' => function ($query) {
                        $query->whereHas('reviews',function ($query) {
                            $query->where('published', true);
                        });
                    }])->having('girls_count', '>', 0);
                }])->withCount(['girls' => function ($query) {
                    $query->whereHas('reviews',function ($query) {
                        $query->where('published', true);
                    });
                }, 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
        if ($section == Girl::FILTER_SECTION_AGENCIES) {
            return Cache::tags(Country::class)->remember('country_slug_' . $slug . '_' . $section, 30, function () use ($slug) {
                return Country::with(['translations', 'category'])->withCount(['agencies', 'offers'])
                    ->active()
                    ->where('slug', $slug)
                    ->firstOrFail();
            });
        }
    }

    public function getGirlPublicationCostInCountry(Country $country): float
    {
        if($country->category)
            return $country->category->girl_publication_cost;
        return config('costs.girl_publication_cost');
    }

    public function getGirlPhoneCostInCountry(Country $country): float
    {
        if($country->category)
            return $country->category->girl_phone_cost;
        return config('costs.girl_phone_cost');
    }

    public function findForAdmin($id): Country
    {
        return $this->country->active()
            ->findOrFail($id);
    }

}
