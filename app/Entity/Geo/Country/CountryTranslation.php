<?php

namespace App\Entity\Geo\Country;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'name_prepositional', 'name_genitive', 'name_instrumental', 'name_accusative', 'name_dative'];

}
