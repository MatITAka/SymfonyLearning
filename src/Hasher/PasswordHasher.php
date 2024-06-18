<?php

namespace App\Hasher;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class PasswordHasher implements PasswordHashInterface
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function hash(string $plainPassword): string
    {
        // Create a temporary User object to pass to the hasher
        $user = new User();
        $user->setPassword($plainPassword);

        return $this->userPasswordHasher->hashPassword($user, $plainPassword);
    }
}
