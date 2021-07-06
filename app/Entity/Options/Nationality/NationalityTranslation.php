<?php

namespace App\Entity\Options\Nationality;

use Illuminate\Database\Eloquent\Model;

class NationalityTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];

}
