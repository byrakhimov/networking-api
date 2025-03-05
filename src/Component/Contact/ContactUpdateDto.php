<?php

declare(strict_types=1);

namespace App\Component\Contact;

use App\Entity\MediaObject;
use Symfony\Component\Serializer\Annotation\Groups;

class ContactUpdateDto
{
    #[Groups(['contact:write'])]
    public ?string $givenName = null;

    #[Groups(['contact:write'])]
    public ?string $familyName = null;

    #[Groups(['contact:write'])]
    public ?string $email = null;

    #[Groups(['contact:write'])]
    public ?string $phone = null;

    #[Groups(['contact:write'])]
    public ?string $profession = null;

    #[Groups(['contact:write'])]
    public ?MediaObject $image = null;

    #[Groups(['contact:write'])]
    public ?string $relationship = null;
}
