<?php

declare (strict_types=1);

namespace App\Component\Meeting;

use App\Entity\Meeting;
use App\Entity\Person;
use App\Entity\User;

class MeetingFactory
{
    public function create(
        Person $person,
        string $description,
        User $createdBy,
    ): Meeting {
        return (new Meeting())
            ->setPerson($person)
            ->setDescription($description)
            ->setCreatedBy($createdBy);
    }
}
