<?php

namespace App\Entity\Tariffs;

use Illuminate\Database\Eloquent\Model;

class PublicationTariffTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name', 'description'];

}
