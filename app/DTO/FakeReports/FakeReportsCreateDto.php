<?php

namespace App\DTO\FakeReports;

use App\DTO\BaseDto;
use App\Entity\Girl\Girl;

class FakeReportsCreateDto extends BaseDto {

    /** @var string */
    private $report;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /**
     * @Assert\NotNull()
     * @var Girl
     */
    private $girl;

    /**
     * @return string
     */
    public function getReport(): string
    {
        return $this->report;
    }

    /**
     * @param string $report
     */
    public function setReport(string $report): void
    {
        $this->report = $report;
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
}
