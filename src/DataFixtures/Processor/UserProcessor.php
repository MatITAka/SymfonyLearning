<?php
namespace App\DataFixtures\Processor;

use Fidry\AliceDataFixtures\ProcessorInterface;
use App\Hasher\PasswordHashInterface;
use App\Entity\User;

final class UserProcessor implements ProcessorInterface
{
    private $passwordHasher;

    public function __construct(PasswordHashInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @inheritdoc
     */
    public function preProcess(string $fixtureId, $object): void
    {
        if (false === $object instanceof User) return;

        $hashedPassword = $this->passwordHasher->hash($object->getPassword());
        $object->setPassword($hashedPassword);
    }

    /**
     * @inheritdoc
     */
    public function postProcess(string $fixtureId, $object): void
    {
        // do nothing
    }
}


