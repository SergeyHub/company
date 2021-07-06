<?php

namespace App\Entity\Offer;

use App\Entity\Clients\Client;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['name', 'content'];

    public const STATUS_WAIT = 'wait';
    public const STATUS_INSPECTION = 'inspection';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CLOSED = 'closed';

    public static function statusesList(): array
    {
        return [
            self::STATUS_WAIT,
            self::STATUS_INSPECTION,
            self::STATUS_PUBLISHED,
            self::STATUS_CLOSED,
        ];
    }


    public function wait()
    {
        $this->status = static::STATUS_WAIT;
        $this->save();
    }

    /**
     * Отправка на проверку
     */
    public function setInspection()
    {
        $this->status = self::STATUS_INSPECTION;
        $this->save();
    }

    /**
     * Публикация
     */
    public function publish()
    {
        $this->status = static::STATUS_PUBLISHED;
        $this->save();
    }

    public function close()
    {
        $this->status = static::STATUS_CLOSED;
        $this->save();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where('status', self::STATUS_PUBLISHED);
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
