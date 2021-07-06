<?php

namespace App\Entity\Geo\City;

use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\Entity\Offer\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name', 'name_prepositional', 'name_genitive'];
    protected $fillable = ['slug', 'status', 'country_id'];
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function girls()
    {
        return $this->hasMany(Girl::class, 'city_id')
            ->where('status', Girl::STATUS_PUBLISHED);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'city_id')
            ->where('status', Offer::STATUS_PUBLISHED);
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', 1);
    }

}
