<?php

namespace Hellspite\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('HellspiteMediaBundle:Default:index.html.twig');
    }

    public function albumAction($slug){
        $em = $this->getDoctrine()->getEntityManager();
        $album = $em->getRepository('HellspiteMediaBundle:Album')->findBySlug($slug);
        $photos = $em->getRepository('HellspiteMediaBundle:Photo')->getByAlbum($album->getId());

        return $this->render('HellspiteMediaBundle:Default:album.html.twig', 
            array('photos' => $photos, 'album' => $album)
        );
    }
}
