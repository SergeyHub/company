<?php

namespace App\Entity\Options\ContactMethod;

use Illuminate\Database\Eloquent\Model;

class ContactMethodTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];

}
