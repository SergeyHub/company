<?php

namespace App\Entity\Options\Purpose;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
