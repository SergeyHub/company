<?php
/**
 * Created by PhpStorm.
 * User: daniil
 * Date: 2019-05-10
 * Time: 11:24
 */

namespace App\DTO\Clients;

use App\DTO\BaseDto;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\Nationality\Nationality;
use App\ValueObjects\Translation;

class ClientDto extends BaseDto
{

    /** @var string */
    private $name;

    /** @var string */
    private $phone;

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


    /** @var Translation[]|null */
    private $about;

    /**
     * @return string
     */
    public function getName(): string
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
     * @return string
     */
    public function getPhone(): string
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
     * @return int
     */
    public function getAge(): int
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
     * @return Translation[]|null
     */
    public function getAbout(): ?array
    {
        return $this->about;
    }

    /**
     * @param Translation[]|null $about
     */
    public function setAbout(?array $about): void
    {
        $this->about = $about;
    }


}
