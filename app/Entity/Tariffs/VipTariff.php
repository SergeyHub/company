<?php

namespace App\Entity\Tariffs;

use Illuminate\Database\Eloquent\Model;

class VipTariff extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name', 'description'];
    public $timestamps = false;

}
