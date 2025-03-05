<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Component\Person\PersonFactory;
use App\Entity\Person;
use App\Entity\User;
use DateTime;
use LogicException;

class UserWithPersonBuilder
{
    private User $user;
    private Person $person;

    public function __construct(
        private UserFactory $userFactory,
        private PersonFactory $personFactory
    ) {
    }

    public function buildUser(string $email, string $password): self
    {
        $this->user = $this->userFactory->create($email, $password);

        return $this;
    }

    public function buildPerson(
        ?string $givenName = null,
        ?string $familyName = null,
        ?DateTime $birthDay = null,
        ?string $phone = null
    ): self {
        if ($this->user === null) {
            throw new LogicException("You must call buildUser() method first before calling this");
        }
        $this->person = $this->personFactory->create(
            $this->user,
            $givenName,
            $familyName,
            $birthDay,
            $phone
        );

        return $this;
    }

    public function getResult(): Person
    {
        if (!isset($this->person)) {
            throw new LogicException('Person object has not been built yet.');
        }

        return $this->person;
    }
}
