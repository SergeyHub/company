<?php

namespace App\Entity\Options\Body;

use Illuminate\Database\Eloquent\Model;

class Body extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
