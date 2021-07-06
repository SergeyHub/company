<?php

namespace App\Entity\Girl;

use Illuminate\Database\Eloquent\Model;

class GirlMeetingPoint extends Model
{

    public $timestamps = false;
    protected $fillable = ['girl_id', 'type', 'place'];

    public const PLACE_HOTEL = 'hotel';
    public const PLACE_FLAT = 'flat';

    public const TYPE_INCALL = 'incall';
    public const TYPE_OUTCALL = 'outcall';

    public static function getPlacesList(): array
    {
        return [self::PLACE_FLAT, self::PLACE_HOTEL];
    }

    public static function getTypesList(): array
    {
        return [self::TYPE_INCALL, self::TYPE_OUTCALL];
    }
}
