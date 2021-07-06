<?php

namespace App\Entity\Faq;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['question', 'answer'];

}
