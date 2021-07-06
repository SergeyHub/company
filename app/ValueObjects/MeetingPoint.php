<?php

namespace App\ValueObjects;

use App\Entity\Girl\GirlMeetingPoint;

class MeetingPoint
{

    /** @var string */
    private $type;

    /** @var string */
    private $place;

    public function __construct(string $type, string $place)
    {
        if(!in_array($type, GirlMeetingPoint::getTypesList()))
            throw new \InvalidArgumentException('Invalid meeting type');

        if(!in_array($place, GirlMeetingPoint::getPlacesList()))
            throw new \InvalidArgumentException('Invalid place type');

        $this->type = $type;
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

}
