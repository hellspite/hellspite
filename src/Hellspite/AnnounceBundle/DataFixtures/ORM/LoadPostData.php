<?php
namespace Hellspite\AnnounceBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hellspite\AnnounceBundle\Entity\Post;
use Hellspite\AnnounceBundle\Entity\PostTranslation;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $y = new \DateTime();
        $y->modify('-1 day');

        $today = new Post();
        $today->setDate(new \DateTime());
        $today->setTitle('Test today');
        $today->setText('Lorem ipsum dolor sit amet');

        $today->addTranslation(new PostTranslation('it', 'title', 'Prova Oggi'));
        $today->addTranslation(new PostTranslation('it', 'text', 'Prova Oggi Testo'));

        $manager->persist($today);


        $yesterday = new Post();
        $yesterday->setDate($y);
        $yesterday->setTitle('Test yesterday');
        $yesterday->setText('Lorem ipsum dolor sit amet');

        $yesterday->addTranslation(new PostTranslation('it', 'title', 'Prova Ieri'));
        $yesterday->addTranslation(new PostTranslation('it', 'text', 'Prova Ieri Testo'));
         
        $manager->persist($yesterday);

        $manager->flush();

        $today->setTitle('Prova Oggi');
        $today->setText('Prova Oggi Testo');
        $today->setTranslatableLocale('it');

        $manager->persist($today);

        $yesterday->setTitle('Prova Ieri');
        $yesterday->setText('Prova Ieri Testo');
        $yesterday->setTranslatableLocale('it');
         
        $manager->persist($yesterday);

        $manager->flush();
    }
}
