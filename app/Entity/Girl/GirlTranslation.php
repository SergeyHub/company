<?php

namespace App\Entity\Girl;

use Illuminate\Database\Eloquent\Model;

class GirlTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['about', 'dating_imagine'];

}
