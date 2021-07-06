<?php

namespace App\DTO\Messages;

use App\DTO\BaseDto;
use App\Entity\User\User;

class MessageDto extends BaseDto
{

    /** @var string */
    private $content;

    /** @var User */
    private $user_from;

    /** @var User */
    private $user_to;

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
    public function getUserFrom(): User
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

}
