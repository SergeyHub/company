<?php

namespace App\Entity\Options\Nationality;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;
}
