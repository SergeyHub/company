<?php

namespace App\Entity\Options\ReadyFor;

use Illuminate\Database\Eloquent\Model;

class ReadyFor extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
