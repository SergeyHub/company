<?php

namespace App\Entity\Options\Eye;

use Illuminate\Database\Eloquent\Model;

class Eye extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
