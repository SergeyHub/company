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

class GirlCreateDto extends BaseDto {

    /**
     * @Assert\NotBlank()
     * @var string|null
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @var string|null
     */
    private $real_name;

    /**
     * @Assert\NotBlank()
     * @var string|null
     */
    private $phone;

    /**
     * @var ReadyForTravels
     */
    private $ready_for_travels;

    /**
     * @Assert\NotNull()
     * @var Country
     */
    private $country;

    /**
     * @Assert\NotNull()
     * @var City
     */
    private $city;

    /**
     * @Assert\NotNull()
     * @var Nationality
     */
    private $nationality;

    /**
     * @Assert\NotNull()
     * @var Ethnicity
     */
    private $ethnicity;

    /**
     * @Assert\NotNull()
     * @var Orientation
     */
    private $orientation;

    /**
     * @Assert\NotNull()
     * @var BodyHair
     */
    private $body_hair;

    /**
     * @Assert\NotNull()
     * @var Body
     */
    private $body;

    /** @var Hair */
    private $hair;

    /** @var Eye */
    private $eye;

    /**
     * @Assert\NotNull()
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\GreaterThanOrEqual(
     *     value = 18
     * )
     * @var int
     */
    private $age;

    /** @var User */
    private $user;

    /** @var Translation[]|null */
    private $about;

    /** @var int[]|null */
    private $languages;

    /** @var int[]|null */
    private $geographies;

    /** @var int[]|null */
    private $what_likes;

    /** @var int[]|null */
    private $ready_fors;

    /** @var string|null */
    private $profile_site;

    /** @var boolean */
    private $pornstar;

    /** @var boolean|null */
    private $vip;

    /** @var int[]|null */
    private $possible_countries;

    /** @var int[]|null */
    private $contact_methods;

    /** @var MeetingPoint[]|null */
    private $meeting_points;

    /** @var string[]|null */
    private $meeting_with;

    /** @var GirlCost[]|null */
    private $costs;

    /** @var int|null */
    private $weight;

    /** @var int|null */
    private $height;

    /** @var int|null */
    private $bust;

    /** @var int|null */
    private $waist;

    /** @var int|null */
    private $hip;

    /**
     * @return int|null
     */
    public function getWeight(): ?int
    {
        return $this->weight;
    }

    /**
     * @param int|null $weight
     */
    public function setWeight(?int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @param int|null $height
     */
    public function setHeight(?int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return int|null
     */
    public function getBust(): ?int
    {
        return $this->bust;
    }

    /**
     * @return boolean|null
     */
    public function getReadyForTravels(): ?bool
    {
        return (boolean) $this->ready_for_travels;
    }

    /**
     * @param boolean|null $ready_for_travels
     */
    public function setReadyForTravels(?bool $ready_for_travels): void
    {
        $this->ready_for_travels = $ready_for_travels;
    }

    /**
     * @param int|null $bust
     */
    public function setBust(?int $bust): void
    {
        $this->bust = $bust;
    }

    /**
     * @return int|null
     */
    public function getWaist(): ?int
    {
        return $this->waist;
    }

    /**
     * @param int|null $waist
     */
    public function setWaist(?int $waist): void
    {
        $this->waist = $waist;
    }

    /**
     * @return int|null
     */
    public function getHip(): ?int
    {
        return $this->hip;
    }

    /**
     * @param int|null $hip
     */
    public function setHip(?int $hip): void
    {
        $this->hip = $hip;
    }

    /**
     * @return Translation[]|null
     */
    public function getAbout(): ?array
    {
        return $this->about;
    }

    /**
     * @param Translation[] $about
     */
    public function setAbout(array $about): void
    {
        $this->about = $about;
    }

    /**
     * @return Nationality
     */
    public function getNationality(): Nationality
    {
        return $this->nationality;
    }

    /**
     * @param Nationality $nationality
     */
    public function setNationality(Nationality $nationality): void
    {
        $this->nationality = $nationality;
    }


    /**
     * @return Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }

    /**
     * @param Body $body
     */
    public function setBody(Body $body): void
    {
        $this->body = $body;
    }


    /**
     * @return BodyHair
     */
    public function getBodyHair(): BodyHair
    {
        return $this->body_hair;
    }

    /**
     * @param BodyHair $body_hair
     */
    public function setBodyHair(BodyHair $body_hair): void
    {
        $this->body_hair = $body_hair;
    }


    /**
     * @return Orientation
     */
    public function getOrientation(): Orientation
    {
        return $this->orientation;
    }

    /**
     * @param Orientation $orientation
     */
    public function setOrientation(Orientation $orientation): void
    {
        $this->orientation = $orientation;
    }


    /**
     * @return Ethnicity
     */
    public function getEthnicity(): Ethnicity
    {
        return $this->ethnicity;
    }

    /**
     * @param Ethnicity $ethnicity
     */
    public function setEthnicity(Ethnicity $ethnicity): void
    {
        $this->ethnicity = $ethnicity;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry(Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     */
    public function setCity(City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return Hair
     */
    public function getHair(): Hair
    {
        return $this->hair;
    }

    /**
     * @param Hair $hair
     */
    public function setHair(Hair $hair): void
    {
        $this->hair = $hair;
    }

    /**
     * @return Eye
     */
    public function getEye(): Eye
    {
        return $this->eye;
    }

    /**
     * @param Eye $eye
     */
    public function setEye(Eye $eye): void
    {
        $this->eye = $eye;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int[]|null
     */
    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    /**
     * @param int[]|null $languages
     */
    public function setLanguages(?array $languages): void
    {
        $this->languages = $languages;
    }

    /**
     * @return int[]|null
     */
    public function getGeographies(): ?array
    {
        return $this->geographies;
    }

    /**
     * @param int[]|null $geographies
     */
    public function setGeographies(?array $geographies): void
    {
        $this->geographies = $geographies;
    }

    /**
     * @return int[]|null
     */
    public function getReadyFors(): ?array
    {
        return $this->ready_fors;
    }

    /**
     * @param int[]|null $ready_fors
     */
    public function setReadyFors(?array $ready_fors): void
    {
        $this->ready_fors = $ready_fors;
    }

    /**
     * @return int[]|null
     */
    public function getWhatLikes(): ?array
    {
        return $this->what_likes;
    }

    /**
     * @param int[]|null $what_likes
     */
    public function setWhatLikes(?array $what_likes): void
    {
        $this->what_likes = $what_likes;
    }

    /**
     * @return string|null
     */
    public function getProfileSite(): ?string
    {
        return $this->profile_site;
    }

    /**
     * @param string|null $profile_site
     */
    public function setProfileSite(?string $profile_site): void
    {
        $this->profile_site = $profile_site;
    }

    /**
     * @return boolean|null
     */
    public function getPornstar(): ?bool
    {
        return $this->pornstar;
    }

    /**
     * @param boolean|null $pornstar
     */
    public function setPornstar(?bool $pornstar): void
    {
        $this->pornstar = $pornstar;
    }

    /**
     * @return boolean|null
     */
    public function getVip(): ?bool
    {
        return $this->vip;
    }

    /**
     * @param boolean|null $vip
     */
    public function setVip(?bool $vip): void
    {
        $this->vip = $vip;
    }

    /**
     * @return string|null
     */
    public function getRealName(): ?string
    {
        return $this->real_name;
    }

    /**
     * @param string|null $real_name
     */
    public function setRealName(?string $real_name): void
    {
        $this->real_name = $real_name;
    }

    /**
     * @return int[]|null
     */
    public function getPossibleCountries(): ?array
    {
        return $this->possible_countries;
    }

    /**
     * @param int[]|null $possible_countries
     */
    public function setPossibleCountries(?array $possible_countries): void
    {
        $this->possible_countries = $possible_countries;
    }

    /**
     * @return int[]|null
     */
    public function getContactMethods(): ?array
    {
        return $this->contact_methods;
    }

    /**
     * @param int[]|null $contact_methods
     */
    public function setContactMethods(?array $contact_methods): void
    {
        $this->contact_methods = $contact_methods;
    }


    /**
     * @return MeetingPoint[]|null
     */
    public function getMeetingPoints(): ?array
    {
        return $this->meeting_points;
    }

    /**
     * @param MeetingPoint[]|null $meeting_points
     */
    public function setMeetingPoints(?array $meeting_points): void
    {
        $this->meeting_points = $meeting_points;
    }


    /**
     * @return GirlCost[]|null
     */
    public function getCosts(): ?array
    {
        return $this->costs;
    }

    /**
     * @param GirlCost[]|null $costs
     */
    public function setCosts(?array $costs): void
    {
        $this->costs = $costs;
    }


    /**
     * @return string[]|null
     */
    public function getMeetingWith(): ?array
    {
        return $this->meeting_with;
    }

    /**
     * @param string[]|null $meeting_with
     */
    public function setMeetingWith(?array $meeting_with): void
    {
        $this->meeting_with = $meeting_with;
    }

}
