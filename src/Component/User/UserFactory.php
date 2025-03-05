<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\User;
use DateTime;
use DateTimeZone;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @throws \Exception
     */
    public function create(string $email, string $password): User
    {
        $user = new User();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $createdAt = new DateTime('now', new DateTimeZone('UTC'));

        $user->setEmail($email)
            ->setPassword($hashedPassword)
            ->setCreatedAt($createdAt);

        return $user;
    }
}
