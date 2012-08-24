<?php
namespace Hellspite\MediaBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Hellspite\MediaBundle\Entity\Album;
use Hellspite\MediaBundle\Entity\Photo;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $y = new \DateTime();
        $y->modify('-1 day');

        $album = new Album();
        $album->setDate($y);
        $album->setTitle('Album of yesterday');
        $album->setSubtitle('Thanks to me');
         
        $manager->persist($album);

        $photo1 = new Photo();
        $photo1->setImage('01.jpg');
        $photo1->setCaption('Test 1');
        $photo1->setAlbum($album);

        $manager->persist($photo1);

        $photo2 = new Photo();
        $photo2->setImage('02.jpg');
        $photo2->setCaption('Test 2');
        $photo2->setAlbum($album);

        $manager->persist($photo2);

        $photo3 = new Photo();
        $photo3->setImage('03.jpg');
        $photo3->setCaption('Test 3');
        $photo3->setAlbum($album);

        $manager->persist($photo3);

        $photo4 = new Photo();
        $photo4->setImage('04.jpg');
        $photo4->setCaption('Test 4');
        $photo4->setAlbum($album);

        $manager->persist($photo4);

        $manager->flush();

    }
}

