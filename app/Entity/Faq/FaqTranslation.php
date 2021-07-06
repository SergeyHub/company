<?php

namespace App\Entity\Faq;

use Illuminate\Database\Eloquent\Model;

class FaqTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['question', 'answer'];

}
