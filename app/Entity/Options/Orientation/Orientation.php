<?php

namespace App\Entity\Options\Orientation;

use Illuminate\Database\Eloquent\Model;

class Orientation extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
