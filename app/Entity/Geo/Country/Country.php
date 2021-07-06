<?php

namespace App\Entity\Geo\Country;

use App\Entity\Agency\Agency;
use App\Entity\Agency\CountryAgency;
use App\Entity\Geo\City\City;
use App\Entity\Geo\GeoCategory\GeoCategory;
use App\Entity\Girl\Girl;
use App\Entity\Offer\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name', 'name_prepositional', 'name_genitive'];
    protected $fillable = ['slug', 'status', 'code'];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function category()
    {
        return $this->hasOneThrough(
            GeoCategory::class,
            GeoCategoryCountry::class,
            'country_id',
            'id',
            null,
            'geo_category_id'
        );
    }

    public function girls()
    {
        return $this->hasMany(Girl::class, 'country_id')
            ->where('status', Girl::STATUS_PUBLISHED);
    }

    public function agencies()
    {
        return $this->belongsToMany(Agency::class, 'country_agencies')
            ->where('status', Agency::STATUS_PUBLISHED)
            ->using(CountryAgency::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'country_id')
            ->where('status', Offer::STATUS_PUBLISHED);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', 1);
    }

}
