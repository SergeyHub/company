<?php

namespace App\Entity\Options\Hair;

use Illuminate\Database\Eloquent\Model;

class Hair extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
