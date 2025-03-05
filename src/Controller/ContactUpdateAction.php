<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\Contact\ContactManager;
use App\Component\Contact\ContactUpdateDto;
use App\Component\Helper\IriHelper;
use App\Component\Person\PersonManager;
use App\Component\User\CurrentUser;
use App\Controller\Base\AbstractController;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class ContactUpdateAction extends AbstractController
{
    public function __construct(
        private readonly ContactManager $contactManager,
        private readonly PersonManager $personManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CurrentUser $currentUser,
    ) {
        parent::__construct($serializer, $validator, $currentUser);
    }

    public function __invoke(
        Contact $contact,
        Request $request,
        ContactManager $contactManager,
        PersonManager $personManager,
        IriHelper $helper,
    ): Contact {
        $dto = $this->getDtoFromRequest($request, ContactUpdateDto::class);

        if ($dto->email !== null) {
            $contact->setEmail($dto->email);
        }

        if ($dto->phone !== null) {
            $contact->setPhone($dto->phone);
        }

        if ($dto->profession !== null) {
            $contact->setProfession($dto->profession);
        }

        if ($dto->image !== null) {
            $contact->setImage($dto->image);
        }

        if ($dto->relationship !== null) {
           $contact->setRelationship($helper->relationConvertToContact($dto->relationship));
        }

        if ($contact->getPerson() !== null) {
            if ($dto->givenName !== null) {
                $contact->getPerson()->setGivenName($dto->givenName);
            }

            if ($dto->familyName !== null) {
                $contact->getPerson()->setFamilyName($dto->familyName);
            }

            $this->personManager->save($contact->getPerson(), true);
        }

        $this->contactManager->save($contact, true);

        return $contact;
    }
}
