<?php

declare(strict_types=1);

namespace App\Component\Contact;

use App\Entity\Contact;
use App\Entity\MediaObject;
use App\Entity\User;
use DateTime;
use InvalidArgumentException;

class ContactFactory
{
    public function create(
        User $user,
        ?string $email = null,
        ?string $phone = null,
        ?string $profession = null,
        ?MediaObject $image = null,
        ?Contact $relationship = null
    ): Contact {
        $this->checkExistsEmailOrPhone($phone, $email);

        return (new Contact())
            ->setEmail($email)
            ->setPhone($phone)
            ->setProfession($profession)
            ->setImage($image)
            ->setRelationship($relationship)
            ->setCreatedAt(new DateTime())
            ->setCreatedBy($user);
    }

    private function checkExistsEmailOrPhone(?string $phone, ?string $email): void
    {
        if ($phone === null && $email === null) {
            throw new InvalidArgumentException('Email or phone number must be provided');
        }
    }
}
