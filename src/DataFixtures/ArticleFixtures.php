<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $article->setActive(true);
            $article->setCreatedAt(new DateTimeImmutable());
            $article->setAuthor("Michel");
            $article->setTitle($this->generateRandomString(15));
            $article->setShortTitle($this->generateRandomString());
            $article->setText($this->generateRandomString(1500));
            $article->setCoverImage("5.png");
            $manager->persist($article);
        }

        $manager->flush();
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
