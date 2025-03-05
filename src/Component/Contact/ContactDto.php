<?php

declare(strict_types=1);

namespace App\Component\Contact;

use App\Entity\Contact;
use App\Entity\MediaObject;
use App\Entity\Person;
use Symfony\Component\Serializer\Annotation\Groups;

class ContactDto
{
    #[Groups(['contacts:read', 'contact:write'])]
    public int $id;

    #[Groups(['person:read', 'person:write', 'contacts:read'])]
    public ?string $givenName = null;

    #[Groups(['person:read', 'person:write', 'contacts:read'])]
    public ?string $familyName = null;

    #[Groups(['contacts:read', 'contact:write'])]
    public ?string $email = null;

    #[Groups(['contacts:read', 'contact:write'])]
    public ?string $phone = null;

    #[Groups(['contacts:read', 'contact:write'])]
    public ?string $profession = null;

    #[Groups(['contacts:read', 'contact:write'])]
    public ?MediaObject $image = null;

    public function __construct(Contact $contact)
    {
        $this->id = $contact->getId();
        $this->email = $contact->getEmail();
        $this->phone = $contact->getPhone();
        $this->profession = $contact->getProfession();
        $this->image = $contact->getImage();

        $person = $contact->getPerson();

        if ($person instanceof Person) {
            $this->givenName = $person->getGivenName();
            $this->familyName = $person->getFamilyName();
        }
    }
}
