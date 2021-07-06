<?php

namespace App\Entity\ProfileSite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProfileSite extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_NOT_ACTIVE = 'not_active';

    public $timestamps = false;

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
