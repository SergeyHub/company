<?php

namespace App\Entity\Bill;

use App\Entity\Orders\OrderClientAccess;
use App\Entity\Orders\OrderGirlPhone;
use App\Entity\Orders\OrderOfferPublication;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Bill extends Model
{

    use SoftDeletes;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELED = 'canceled';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->morphTo();
    }

    public function isActive(): bool
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    public function isPaid(): bool
    {
        return $this->status == static::STATUS_PAID;
    }

    public function isCanceled(): bool
    {
        return $this->status == static::STATUS_CANCELED;
    }

    public function setPaid(): bool
    {
        if($this->status !== static::STATUS_ACTIVE)
            return false;

        $this->status = static::STATUS_PAID;
        $this->payed_at = now();
        $this->save();

        return true;
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', static::STATUS_ACTIVE);
    }

    /**
     * Get order type
     * @return string|null
     * @throws \ReflectionException
     */
    public function getType(): ?string
    {
        if(!$this->order)
            return null;
        return (new \ReflectionClass($this->order))->getShortName();
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
