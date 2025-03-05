<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/contacts/search', name: 'contacts_search', methods: ['GET'])]
class ContactSearchAction extends AbstractController
{
    /**
     * @return Contact[]
     */
    public function __invoke(Request $request, ContactRepository $contactRepository): array
    {
        $givenName = $request->query->get('person.givenName')
            ?? $request->query->get('person_givenName')
            ?? $request->query->get('givenName');

        $familyName = $request->query->get('person.familyName')
            ?? $request->query->get('person_familyName')
            ?? $request->query->get('familyName');

        $criteria = [
            'id'         => $request->query->get('id'),
            'givenName'  => $givenName,
            'familyName' => $familyName,
            'email'      => $request->query->get('email'),
            'phone'      => $request->query->get('phone'),
            'profession' => $request->query->get('profession'),
            'image'      => $request->query->get('image'),
        ];

        return $contactRepository->searchContacts($criteria);
    }
}
