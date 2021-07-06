<?php

namespace App\ValueObjects;

class GirlCost
{

    /** @var string */
    private $duration;

    /** @var int */
    private $currency_id;

    /** @var int */
    private $amount;

    public function __construct(string $duration, int $currency_id, int $amount)
    {
        if(!in_array($duration, \App\Entity\Girl\GirlCost::getDurationsList()))
            throw new \InvalidArgumentException('Invalid duration type');

        $this->duration = $duration;
        $this->currency_id = $currency_id;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currency_id;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

}
