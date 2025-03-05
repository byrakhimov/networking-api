<?php

declare(strict_types=1);

namespace App\Component\User\Dtos;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

class RegistrationDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Email]
        #[Groups(['user:write'])]
        private string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6)]
        #[Groups(['user:write'])]
        private string $password,

        #[Assert\NotBlank]
        #[Groups(['user:write'])]
        private string $givenName,

        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: "/^\+?[0-9]{1,4}?[ ()0-9\-]{6,}$/",
            message: "Phone number must be valid."
        )]
        #[Groups(['user:write'])]

        private string $phone,

        #[Groups(['user:write'])]
        #[ORM\Column(nullable: true)]
        private ?string $profession = null,

        #[Groups(['user:write'])]
        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: "/^\d{4}-\d{2}-\d{2}$/",
            message: "The birthday must be in 'YYYY-MM-DD' format."
        )]
        private string $birthday,

        #[Groups(['user:write'])]
        private ?string $familyName = null,
    ) {

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getProfession(): string
    {
        return $this->profession;
    }
}
