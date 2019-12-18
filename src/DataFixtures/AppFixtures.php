<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article1 = new Article();
        $article1->setTitle('Introduction à Symfony')
            ->setBody('Un framework PHP')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-12'));

        $article2 = new Article();
        $article2->setTitle('Fondamentaux de Symfony')
            ->setBody('Dialogue HTTP')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-19'));

        $article3 = new Article();
        $article3->setTitle('Routing de Symfony')
            ->setBody('Annotation dans le contrôleur')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-26'));

        $manager->persist($article1);
        $manager->persist($article2);
        $manager->persist($article3);
        $manager->flush();
    }
}
