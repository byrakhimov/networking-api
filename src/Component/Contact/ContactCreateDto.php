<?php

declare(strict_types=1);

namespace App\Component\Contact;

use App\Entity\Contact;
use App\Entity\MediaObject;
use Symfony\Component\Serializer\Annotation\Groups;

class ContactCreateDto
{
    public function __construct(
        #[Groups(['contact:read', 'contact:write'])]
        private string $givenName,

        #[Groups(['contact:read', 'contact:write'])]
        private string $familyName,

        #[Groups(['contact:read', 'contact:write'])]
        private ?string $email,

        #[Groups(['contact:read', 'contact:write'])]
        private ?string $phone,

        #[Groups(['contact:read', 'contact:write'])]
        private ?string $profession,

        #[Groups(['contact:read', 'contact:write'])]
        private ?MediaObject $image,

        #[Groups(['contact:read', 'contact:write'])]
        private ?string $relationship,
    ) {
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }
}
