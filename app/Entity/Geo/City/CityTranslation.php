<?php

namespace App\Entity\Geo\City;

use Illuminate\Database\Eloquent\Model;

class CityTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'name_prepositional', 'name_genitive', 'name_instrumental', 'name_accusative', 'name_dative'];

}
