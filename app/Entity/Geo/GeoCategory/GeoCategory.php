<?php

namespace App\Entity\Geo\GeoCategory;

use App\Entity\Geo\Country\Country;
use App\Entity\Geo\Country\GeoCategoryCountry;
use Illuminate\Database\Eloquent\Model;

class GeoCategory extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

    public function countries()
    {
        return $this->belongsToMany(Country::class)
            ->using(GeoCategoryCountry::class);
    }

}
