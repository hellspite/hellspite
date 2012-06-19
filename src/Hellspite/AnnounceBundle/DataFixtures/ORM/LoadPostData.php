<?php
namespace Hellspite\AnnounceBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hellspite\AnnounceBundle\Entity\Post;

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

        $manager->persist($today);


        $yesterday = new Post();
        $yesterday->setDate($y);
        $yesterday->setTitle('Test yesterday');
        $yesterday->setText('Lorem ipsum dolor sit amet');
         
        $manager->persist($yesterday);

        $manager->flush();
    }
}
