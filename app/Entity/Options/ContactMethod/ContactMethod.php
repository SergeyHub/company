<?php

namespace App\Entity\Options\ContactMethod;

use Illuminate\Database\Eloquent\Model;

class ContactMethod extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    public $timestamps = false;

}
