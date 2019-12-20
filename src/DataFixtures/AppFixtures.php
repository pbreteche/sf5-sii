<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@site.fr');
        $user->setPassword($this->encoder->encodePassword($user, 'coucou'));
        $user->setRoles(['ROLE_ADMIN']);

        $tag1 = (new Tag())->setName('PHP');
        $tag2 = (new Tag())->setName('Symfony');
        $tag3 = (new Tag())->setName('MySql');

        $article1 = new Article();
        $article1->setTitle('Introduction à Symfony')
            ->setBody('Un framework PHP')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-12'))
            ->addTag($tag1)->addTag($tag2);

        $article2 = new Article();
        $article2->setTitle('Fondamentaux de Symfony')
            ->setBody('Dialogue HTTP')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-19'))
            ->addTag($tag1);

        $article3 = new Article();
        $article3->setTitle('Routing de Symfony')
            ->setBody('Annotation dans le contrôleur')
            ->setCreatedAt(new \DateTimeImmutable('2019-10-26'))
            ->addTag($tag3);

        $article1->setAuthor($user);
        $article2->setAuthor($user);
        $article3->setAuthor($user);

        $manager->persist($user);
        $manager->persist($tag1);
        $manager->persist($tag2);
        $manager->persist($tag3);
        $manager->persist($article1);
        $manager->persist($article2);
        $manager->persist($article3);
        $manager->flush();
    }
}
