<?php

namespace App\Entity\Options\BodyHair;

use Illuminate\Database\Eloquent\Model;

class BodyHair extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
