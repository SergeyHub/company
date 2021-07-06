<?php

namespace App\DTO\Girls;

use App\DTO\BaseDto;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\Body\Body;
use App\Entity\Options\BodyHair\BodyHair;
use App\Entity\Options\Ethnicity\Ethnicity;
use App\Entity\Options\Eye\Eye;
use App\Entity\Options\Hair\Hair;
use App\Entity\Options\Nationality\Nationality;
use App\Entity\Options\Orientation\Orientation;
use App\Entity\User\User;
use App\ValueObjects\GirlCost;
use App\ValueObjects\MeetingPoint;
use App\ValueObjects\Translation;
use Symfony\Component\Validator\Constraints as Assert;

class GirlRejectVerificationDto extends BaseDto {
    /** @var reason */
    private $reason;

    /**
     * @return int|null
     */
    public function setReason(array $reason): void
    {
        $this->reason = $reason;
    }

    public function getReason(): array {

        return [
            'en' => $this->reason['en'] ?? '',
            'ru' => $this->reason['ru'] ?? ''
        ];
    }
}
