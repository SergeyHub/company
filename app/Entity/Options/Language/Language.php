<?php

namespace App\Entity\Options\Language;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
