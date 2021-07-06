<?php

namespace App\DTO\Reviews;

use App\DTO\BaseDto;
use App\Entity\Bill\Currency\Currency;
use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\ValueObjects\Translation;

class ReviewsCreateDto extends BaseDto {

    /** @var Translation[]|null */
    private $review;

    /** @var string */
    private $nickname;

    /** @var string */
    private $email;

    /** @var string */
    private $meeting_date;

    /** @var int */
    private $duration;

    /** @var Translation[]|null */
    private $meeting_city;

    /** @var string */
    private $duration_type;

    /** @var int */
    private $price;

    /** @var bool */
    private $published;

    /**
     * @Assert\NotNull()
     * @var Country
     */
    private $country;

    /**
     * @Assert\NotNull()
     * @var Currency
     */
    private $currency;

    /**
     * @Assert\NotNull()
     * @var Girl
     */
    private $girl;

    /**
     * @Assert\NotNull
     * @var int
     */
    private $stars;

    /**
     * @return Translation[]|null
     */
    public function getReview(): ?array
    {
        return $this->review;
    }

    /**
     * @param Translation[] $review
     */
    public function setReview(array $review): void
    {
        $this->review = $review;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param int$stars
     */
    public function setStars(int $stars): void
    {
        $this->stars = $stars;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getMeetingDate(): ?string
    {
        return $this->meeting_date;
    }

    /**
     * @return int
     */
    public function getStars(): int
    {
        return $this->stars;
    }

    /**
     * @param string $meeting_date
     */
    public function setMeetingDate(string $meeting_date): void
    {
        $this->meeting_date = $meeting_date;
    }

    /**
     * @return Translation[]|null
     */
    public function getMeetingCity(): ?array
    {
        return $this->meeting_city;
    }

    /**
     * @param Translation[] $meeting_city
     */
    public function setMeetingCity(array $meeting_city): void
    {
        $this->meeting_city = $meeting_city;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDurationType(): string
    {
        return $this->duration_type;
    }

    /**
     * @param string $duration_type
     */
    public function setDurationType(string $duration_type): void
    {
        $this->duration_type = $duration_type;
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
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     */
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return Girl
     */
    public function getGirl(): Girl
    {
        return $this->girl;
    }

    /**
     * @param Girl $girl
     */
    public function setGirl(Girl $girl): void
    {
        $this->girl = $girl;
    }

    /**
     * @return bool
     */
    public function getPublished(): bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

}
