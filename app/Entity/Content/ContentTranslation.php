<?php

namespace App\Entity\Content;

use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['content'];

}
