<?php
namespace Hellspite\GigBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hellspite\GigBundle\Entity\Gig;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $y = new \DateTime();
        $y->modify('-1 day');

        $today = new Gig();
        $today->setDate(new \DateTime());
        $today->setTitle('Test today');
        $today->setText('Lorem ipsum dolor sit amet');

        $manager->persist($today);


        $yesterday = new Gig();
        $yesterday->setDate($y);
        $yesterday->setTitle('Test yesterday');
        $yesterday->setText('Lorem ipsum dolor sit amet');
         
        $manager->persist($yesterday);

        $manager->flush();
    }
}

