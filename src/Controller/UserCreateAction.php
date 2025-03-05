<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\Person\PersonManager;
use App\Component\User\CurrentUser;
use App\Component\User\Dtos\RegistrationDto;
use App\Component\User\UserManager;
use App\Component\User\UserWithPersonBuilder;
use App\Controller\Base\AbstractController;
use App\Entity\Person;
use App\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class UserCreateAction extends AbstractController
{
    private UserWithPersonBuilder $userWithPersonBuilder;

    public function __construct(
        UserWithPersonBuilder $userWithPersonBuilder,
        private UserManager $userManager,
        private PersonManager $personManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CurrentUser $currentUser
    ) {
        parent::__construct($serializer, $validator, $currentUser);
        $this->userWithPersonBuilder = $userWithPersonBuilder;
    }

    public function __invoke(Request $request): User
    {
        $registrationRequest = $this->convertRequestToDo($request);
        $person = $this->buildUserWithPerson($registrationRequest);

        $this->userManager->save($person->getCreatedBy());
        $this->personManager->save($person, true);

        return $person->getCreatedBy();
    }

    private function convertRequestToDo(Request $request): RegistrationDto
    {
        /** @var RegistrationDto $registrationRequest */
        $registrationRequest = $this->getDtoFromRequest($request, RegistrationDto::class);
        $this->validate($registrationRequest);

        return $registrationRequest;
    }

    private function buildUserWithPerson(RegistrationDto $registrationRequest): Person
    {
        return $this->userWithPersonBuilder
            ->buildUser($registrationRequest->getEmail(), $registrationRequest->getPassword())
            ->buildPerson(
                $registrationRequest->getGivenName(),
                $registrationRequest->getFamilyName(),
                new DateTime($registrationRequest->getBirthday()),
                $registrationRequest->getPhone()
            )
            ->getResult();
    }
}
