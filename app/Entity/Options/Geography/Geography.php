<?php

namespace App\Entity\Options\Geography;

use Illuminate\Database\Eloquent\Model;

class Geography extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
