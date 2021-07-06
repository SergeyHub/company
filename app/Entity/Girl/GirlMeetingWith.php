<?php

namespace App\Entity\Girl;

use Illuminate\Database\Eloquent\Model;

class GirlMeetingWith extends Model
{

    public $timestamps = false;

    protected $fillable = ['type'];

    public const TYPE_GIRLS = 'girls';
    public const TYPE_BOYS = 'boys';
    public const TYPE_COUPLES = 'couples';

    public static function getTypesList(): array
    {
        return [self::TYPE_GIRLS, self::TYPE_BOYS, self::TYPE_COUPLES];
    }

}
