<?php

namespace App\Entity\Girl;

use App\Entity\Bill\Currency\Currency;
use Illuminate\Database\Eloquent\Model;

class GirlCost extends Model
{

    public $timestamps = false;

    protected $fillable = ['girl_id', 'currency_id', 'duration', 'amount'];

    public static function getDurationsList(): array
    {
        return ['1_hour', '2_hour', '3_hour', '12_hour', '24_hour'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
