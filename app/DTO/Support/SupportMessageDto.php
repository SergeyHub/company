<?php

namespace App\DTO\Support;

use App\DTO\BaseDto;
use App\Entity\User\User;

class SupportMessageDto extends BaseDto
{

    /** @var string */
    private $content;

    /** @var User */
    private $user;

    /** @var boolean */
    private $from_admin;

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
    public function getUser(): User
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
     * @return bool
     */
    public function isFromAdmin(): bool
    {
        return $this->from_admin;
    }

    /**
     * @param bool $from_admin
     */
    public function setFromAdmin(bool $from_admin): void
    {
        $this->from_admin = $from_admin;
    }

}
