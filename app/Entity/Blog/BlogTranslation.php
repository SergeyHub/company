<?php

namespace App\Entity\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['title', 'content', 'short_description'];

}
