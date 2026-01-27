<?php

namespace App\DataFixtures;

use App\Entity\Conference;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $amsterdam = new Conference();
        $amsterdam->setCity('Amsterdam');
        $amsterdam->setYear('2019');
        $amsterdam->setIsInternational(true);
        $manager->persist($amsterdam);

        $paris = new Conference();
        $paris->setCity('Paris');
        $paris->setYear('2020');
        $paris->setIsInternational(false);
        $manager->persist($paris);

        $comment = new Comment();
        $comment->setConference($amsterdam);
        $comment->setAuthor('Fabien');
        $comment->setEmail('fabien@example.com');
        $comment->setText('There are 1 comments'); // Pour matcher votre test
        // $comment->setState('published');
        $manager->persist($comment);

        $manager->flush();
    }
}