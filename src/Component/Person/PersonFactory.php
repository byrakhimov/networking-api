<?php

declare(strict_types=1);

namespace App\Component\Person;

use App\Entity\Person;
use App\Entity\User;
use DateTime;

class PersonFactory
{
    public function create(
        User $user,
        ?string $givenName = null,
        ?string $familyName = null,
        ?DateTime $birthDay = null,
        ?string $phone = null
    ): Person {
        return (new Person())
            ->setCreatedAt(new DateTime())
            ->setCreatedBy($user)
            ->setUpdatedBy($user)
            ->setGivenName($givenName)
            ->setFamilyName($familyName)
            ->setBirthday($birthDay)
            ->setPhone($phone);
    }
}
