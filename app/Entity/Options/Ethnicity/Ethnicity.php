<?php

namespace App\Entity\Options\Ethnicity;

use Illuminate\Database\Eloquent\Model;

class Ethnicity extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
