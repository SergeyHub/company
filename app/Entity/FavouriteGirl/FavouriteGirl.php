<?php

namespace App\Entity\FavouriteGirl;

use App\Entity\Girl\Girl;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FavouriteGirl extends Pivot
{

    public $timestamps = false;

    protected $table = 'favourite_girls';

    public function girl()
    {
        return $this->belongsTo(Girl::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
