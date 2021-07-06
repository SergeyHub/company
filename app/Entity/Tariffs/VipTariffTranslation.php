<?php

namespace App\Entity\Tariffs;

use Illuminate\Database\Eloquent\Model;

class VipTariffTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'description'];
}
