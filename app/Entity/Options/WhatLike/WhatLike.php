<?php

namespace App\Entity\Options\WhatLike;

use Illuminate\Database\Eloquent\Model;

class WhatLike extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
