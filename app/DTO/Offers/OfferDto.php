<?php

namespace App\DTO\Offers;

use App\DTO\BaseDto;
use App\Entity\Clients\Client;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\ValueObjects\Translation;

class OfferDto extends BaseDto {

    /** @var Translation[]|null */
    private $name;

    /** @var Translation[]|null */
    private $content;

    /** @var Client|null */
    private $client;

    /** @var Country */
    private $country;

    /** @var int|null */
    private $cost;

    /** @var string|null */
    private $status;

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
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

    /** @var City */
    private $city;

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     */
    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }


    /**
     * @return Translation[]|null
     */
    public function getName(): ?array
    {
        return $this->name;
    }

    /**
     * @param Translation[]|null $name
     */
    public function setName(?array $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Translation[]|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * @param Translation[]|null $content
     */
    public function setContent(?array $content): void
    {
        $this->content = $content;
    }


    /**
     * @return int|null
     */
    public function getCost(): ?int
    {
        return $this->cost;
    }

    /**
     * @param int|null $cost
     */
    public function setCost(?int $cost): void
    {
        $this->cost = $cost;
    }

}
