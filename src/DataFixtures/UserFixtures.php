<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user  = new User();
        $user->setUsername('demo');
        $user->setEmail('demo@demo.com');
        $user->setPassword($this->hasher->hashPassword($user, 'demo'));
        $user->addRoles('ROLE_SUPER_ADMIN');
        $manager->persist($user);
        $manager->flush();
    }
}
