<?php

namespace App\Entity\Bill;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    public $timestamps = false;
    protected $fillable = ['title'];

}
