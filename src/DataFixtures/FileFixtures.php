<?php

namespace App\DataFixtures;

use App\Entity\File;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 100; $i++) {
            $file = new File();
            $file->setName($this->generateRandomString());
            $file->setFilePath("7.png");
            $file->setActive(true);
            $file->setCreatedAt(new DateTimeImmutable());
            $manager->persist($file);
        }
        $manager->flush();
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
