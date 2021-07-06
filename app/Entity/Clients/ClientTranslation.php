<?php

namespace App\Entity\Clients;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ClientTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['about'];

}
