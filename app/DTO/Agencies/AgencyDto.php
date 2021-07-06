<?php

namespace App\DTO\Agencies;

use App\DTO\BaseDto;
use App\ValueObjects\Translation;

class AgencyDto extends BaseDto
{

    /** @var string */
    private $name;

    /** @var Translation[] */
    private $description;

    /** @var string */
    private $phone;

    /** @var int[]|null */
    private $contact_methods;

    /** @var int[]|null */
    private $geographies;

    /** @var int[]|null */
    private $countries;

    /** @var string|null */
    private $profile_site;

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
     * @return Translation[]
     */
    public function getDescription(): array
    {
        return $this->description;
    }

    /**
     * @param Translation[] $description
     */
    public function setDescription(array $description): void
    {
        $this->description = $description;
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
     * @return int[]|null
     */
    public function getContactMethods(): ?array
    {
        return $this->contact_methods;
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
    public function getCountries(): ?array
    {
        return $this->countries;
    }

    /**
     * @param int[]|null $countries
     */
    public function setCountries(?array $countries): void
    {
        $this->countries = $countries;
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
     * @param int[]|null $contact_methods
     */
    public function setContactMethods(?array $contact_methods): void
    {
        $this->contact_methods = $contact_methods;
    }

}
