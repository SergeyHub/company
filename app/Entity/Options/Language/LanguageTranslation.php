<?php

namespace App\Entity\Options\Language;

use Illuminate\Database\Eloquent\Model;

class LanguageTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];

}
