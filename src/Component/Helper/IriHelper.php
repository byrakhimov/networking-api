<?php

declare(strict_types=1);

namespace App\Component\Helper;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\Contact;
use InvalidArgumentException;

class IriHelper
{
    public function __construct(private IriConverterInterface $iriConverter)
    {
    }

    public function relationConvertToContact(?string $getRelationship): ?Contact
    {
        if ($getRelationship === null) {
            return null;
        }

        $resource = $this->iriConverter->getResourceFromIri($getRelationship);

        if (!$resource instanceof Contact) {
            throw new InvalidArgumentException("Expected instance of Contact, got " . get_class($resource));
        }

        return $resource;
    }
}
