<?php

namespace App\Entity\Offer;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'content'];

}
