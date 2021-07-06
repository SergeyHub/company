<?php

namespace App\Entity\Wallet;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DISABLED = 'disabled';

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', static::STATUS_ACTIVE);
    }

}
