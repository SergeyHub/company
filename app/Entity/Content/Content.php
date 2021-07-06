<?php

namespace App\Entity\Content;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    use \Astrotomic\Translatable\Translatable;

    protected $fillable = ['slug', 'page'];
    public $translatedAttributes = ['content'];
    public $timestamps = false;

}
