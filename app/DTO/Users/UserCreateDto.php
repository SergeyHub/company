<?php

namespace App\DTO\Users;

use App\DTO\BaseDto;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class UserCreateDto extends BaseDto {

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $role;

    /** @var string */
    private $status;

    /** @var string|null */
    private $type;

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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $girl_type|null
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email(
            array('message' => "The email '{{ value }}' is not a valid email.",)
        ));
        $metadata->addPropertyConstraint('password', new Assert\Length(
            array('min' => 6,
                'max' => 16,
                'minMessage' => "Your password name must be at least {{ limit }} characters long",
                'maxMessage' => "Your password name cannot be longer than {{ limit }} characters")
        ));
        $metadata->addPropertyConstraint('role', new Assert\NotBlank());
        $metadata->addPropertyConstraint('status', new Assert\NotBlank());
    }

}
