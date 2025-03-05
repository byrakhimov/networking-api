<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Component\Contact\ContactCreateDto;
use App\Component\Contact\ContactUpdateDto;
use App\Controller\ContactCreateAction;
use App\Controller\ContactSearchAction;
use App\Controller\ContactUpdateAction;
use App\Controller\DeleteAction;
use App\Entity\Interfaces\CreatedAtSettableInterface;
use App\Entity\Interfaces\CreatedBySettableInterface;
use App\Entity\Interfaces\DeletedAtSettableInterface;
use App\Entity\Interfaces\DeletedBySettableInterface;
use App\Entity\Interfaces\UpdatedAtSettableInterface;
use App\Entity\Interfaces\UpdatedBySettableInterface;
use App\Repository\ContactRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            controller: ContactCreateAction::class,
            input: ContactCreateDto::class,
        ),
        new GetCollection(
            uriTemplate: '/contacts/search',
            controller: ContactSearchAction::class,
            normalizationContext: ['groups' => ['contacts:read']],
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['contacts:read']],
        ),
        new Get(
            security: "is_granted('ROLE_ADMIN') || object.getCreatedBy() == user",
        ),
        new Put(
            controller: ContactUpdateAction::class,
            security: "is_granted('ROLE_ADMIN') || object.getCreatedBy() == user",
            input: ContactUpdateDto::class,
        ),
        new Delete(
            controller: DeleteAction::class,
            security: "is_granted('ROLE_ADMIN') || object.getCreatedBy() == user",
        ),
        new Patch(
            controller: ContactUpdateAction::class,
            security: "is_granted('ROLE_ADMIN') || object.getCreatedBy() == user",
            input: ContactUpdateDto::class,
        ),
    ],
    normalizationContext: ['groups' => ['contact:read', 'contacts:read']],
    denormalizationContext: ['groups' => ['contact:write']],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'email' => 'partial',
    'phone' => 'partial',
    'profession' => 'partial',
    'person.givenName' => 'partial',
    'person.familyName' => 'partial'
])]
class Contact implements
    CreatedAtSettableInterface,
    CreatedBySettableInterface,
    UpdatedAtSettableInterface,
    UpdatedBySettableInterface,
    DeletedAtSettableInterface,
    DeletedBySettableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['contacts:read', 'meeting:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['contacts:read', 'contact:write', 'meeting:read'])]
    private ?Person $person = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['contacts:read', 'contact:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['contacts:read', 'contact:write'])]
    private ?string $phone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['contacts:read'])]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['contacts:read'])]
    private ?User $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['contacts:read'])]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne]
    #[Groups(['contacts:read'])]
    private ?User $updatedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['contacts:read'])]
    private ?DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne]
    private ?User $deletedBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['contacts:read', 'contact:write'])]
    private ?string $profession = null;

    #[ORM\ManyToOne]
    #[Groups(['contacts:read', 'contact:write', 'meeting:read'])]
    private ?MediaObject $image = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'contacts')]
    #[Groups(['contacts:read', 'contact:write'])]
    private ?self $relationship = null;

    #[ORM\OneToMany(mappedBy: 'relationship', targetEntity: self::class)]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?UserInterface $user): self
    {
        $this->createdBy = $user;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?UserInterface $user): self
    {
        $this->updatedBy = $user;
        return $this;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?UserInterface $user): self
    {
        $this->deletedBy = $user;
        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(?string $profession): self
    {
        $this->profession = $profession;
        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(?MediaObject $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(self $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setRelationship($this);
        }

        return $this;
    }

    public function removeContact(self $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            if ($contact->getRelationship() === $this) {
                $contact->setRelationship(null);
            }
        }

        return $this;
    }

    public function getRelationship(): ?self
    {
        return $this->relationship;
    }

    public function setRelationship(?self $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

}
