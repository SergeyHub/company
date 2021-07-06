<?php

namespace App\Entity\ClientApplications;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Entity\User\User;
use App\Entity\Girl\Girl;

class ClientApplication extends Model
{
    protected $table = 'client_applications';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client() {
        return $this->belongsTo(User::class,  'user_from');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userTo() {
        return $this->belongsTo(User::class, 'user_to');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function girl() {
        return $this->belongsTo(Girl::class, 'girl_id');
    }

    /**
     * @param Builder $builder
     * @param BaseFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, BaseFilter $filter)
    {
        return $filter->apply($builder);
    }

}
