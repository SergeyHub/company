<?php

namespace App\DTO\ClientApplications;

use App\DTO\BaseDto;
use App\Entity\User\User;
use App\Entity\Girl\Girl;

class ClientApplicationDto extends BaseDto
{

    /** @var string */
    private $content;

    /** @var User */
    private $user_from;

    /** @var User */
    private $user_to;

    /**
     * @var Girl
     */
    private $girl;

    /**
     * @var string
     */
    private $recall;

    /**
     * @var datetime
     */
    private $meeting_date;

    /**
     * @var string
     */
    private $phone;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return User
     */
    public function getUserFrom(): ?User
    {
        return $this->user_from;
    }

    /**
     * @param User $user_from
     */
    public function setUserFrom(User $user_from): void
    {
        $this->user_from = $user_from;
    }

    /**
     * @return User
     */
    public function getUserTo(): User
    {
        return $this->user_to;
    }

    /**
     * @param User $user_to
     */
    public function setUserTo(User $user_to): void
    {
        $this->user_to = $user_to;
    }

    /**
     * @param Girl $girl
     */
    public function setGirl(Girl $girl): void {
        $this->girl = $girl;
    }

    /**
     * @return Girl
     */
    public function getGirl(): Girl {
        return $this->girl;
    }

    /**
     * @return bool
     */
    public function getRecall(): bool {
        return $this->recall;
    }

    /**
     * @param bool $recall
     */
    public function setRecall(bool $recall): void {
        $this->recall = $recall;
    }

    /**
     * @return datetime
     */
    public function getMeetingDate() {
        return $this->meeting_date;
    }

    /**
     * @param $date
     */
    public function setMeetingDate($date): void {
        $this->meeting_date = $date;
    }

    /**
     * @return string
     */
    public function getPhone(): string {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

}
