<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @param array $criteria
     * @return Contact[]
     */
    public function searchContacts(array $criteria): array
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.person', 'p')
            ->addSelect('p');

        $filtersApplied = false;
        $searchTerms = [];

        $searchFields = [
            'givenName' => 'LOWER(p.givenName)',
            'familyName' => 'LOWER(p.familyName)',
            'profession' => 'LOWER(c.profession)',
            'email' => 'LOWER(c.email)',
            'phone' => 'LOWER(c.phone)',
            'id' => 'c.id'
        ];

        foreach ($searchFields as $field => $fieldAlias) {
            if (!empty($criteria[$field])) {
                $searchTerms[] = "{$fieldAlias} LIKE LOWER(:{$field})";
                $qb->setParameter($field, "%{$criteria[$field]}%");
                $filtersApplied = true;
            }
        }

        if (!$filtersApplied) {
            return [];
        }

        if (count($searchTerms) > 0) {
            $qb->andWhere(implode(' OR ', $searchTerms));
        }

        return $qb->getQuery()->getResult();
    }
}
