<?php

namespace App\Entity\Review;

use Illuminate\Database\Eloquent\Model;

class ReviewTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['review', 'meeting_city'];

}
