<?php

namespace App\Entity\Review;

use App\Entity\Bill\Currency\Currency;
use App\Entity\Geo\Country\Country;
use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['review', 'meeting_city'];

    CONST DAYS = 'days';
    CONST HOURS = 'hours';

    CONST DURATION_TYPES = [
        self::DAYS, self::HOURS
    ];

    protected $dates = [
        'meeting_date'
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function model()
    {
        return $this->morphTo();
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
