<?php

namespace App\DTO\Users;

use App\DTO\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class ResetPasswordDto extends BaseDto {

    /** @var string */
    private $password;

    /** @var string */
    private $resetToken;

    /**
     * @return string|null
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getResetToken(): string {
        return $this->resetToken;
    }

    /**
     * @param $resetToken
     */
    public function setResetToken($resetToken): void {
        $this->resetToken = $resetToken;
    }
}
