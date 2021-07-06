<?php

namespace App\Entity\Subscribes;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{

    protected $fillable = ['user_id', 'type'];

}
