<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\Contact\ContactBuilder;
use App\Component\Contact\ContactCreateDto;
use App\Component\Contact\ContactManager;
use App\Component\Person\PersonManager;
use App\Component\User\CurrentUser;
use App\Controller\Base\AbstractController;
use App\Entity\Contact;
use Symfony\Component\Serializer\SerializerInterface;


class ContactCreateAction extends AbstractController
{
    public function __construct(
        private readonly ContactBuilder $contactBuilder,
        private readonly SerializerInterface $serializer,
        private PersonManager $personManager,
        private ContactManager $contactManager,
        ValidatorInterface $validator,
        CurrentUser $currentUser,

    ) {
        parent::__construct($serializer, $validator, $currentUser);
    }

    public function __invoke(ContactCreateDto $contactCreateDto): Contact
    {
        $person = $this->contactBuilder->buildPerson($this->getUser(), $contactCreateDto);
        $contact = $this->contactBuilder->buildContact($this->getUser(), $contactCreateDto, $person);
        $this->personManager->save($person);
        $this->contactManager->save($contact, true);

        return $contact;
    }
}
