<?php

namespace App\DTO\Users;

use App\DTO\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class UserUpdateDto extends BaseDto {

    /** @var string|null */
    private $password;

    /** @var string|null */
    private $email;

    /** @var string|null */
    private $role;

    /** @var string|null */
    private $type;

    /** @var bool|null */
    private $receive_notifications;

    /**
     * @return bool|null
     */
    public function isReceiveNotifications(): ?bool
    {
        return $this->receive_notifications;
    }

    /**
     * @param bool|null $receive_notifications
     */
    public function setReceiveNotifications(?bool $receive_notifications): void
    {
        $this->receive_notifications = $receive_notifications;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }


}
