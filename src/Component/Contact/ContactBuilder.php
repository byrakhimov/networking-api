<?php

declare(strict_types=1);

namespace App\Component\Contact;

use App\Component\Helper\IriHelper;
use App\Component\Person\PersonFactory;
use App\Entity\Contact;
use App\Entity\Person;
use App\Entity\User;

readonly class ContactBuilder
{
    public function __construct(
        private PersonFactory $personFactory,
        private ContactFactory $contactFactory,
        private IriHelper $helper
    ) {
    }

    public function buildPerson(User $user, ContactCreateDto $dto): Person
    {
        return $this->personFactory->create($user, $dto->getGivenName(), $dto->getFamilyName());
    }

    public function buildContact(User $user, ContactCreateDto $dto, Person $person): Contact
    {
        $contact = $this->contactFactory->create(
            $user,
            $dto->getEmail(),
            $dto->getPhone(),
            $dto->getProfession(),
            $dto->getImage(),
            $this->helper->relationConvertToContact($dto->getRelationship()),
        );

        $contact->setPerson($person);

        return $contact;
    }
}
