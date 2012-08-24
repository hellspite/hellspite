<?php

namespace Hellspite\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $albums = $em->getRepository('HellspiteMediaBundle:Album')->getAll();
        return $this->render('HellspiteMediaBundle:Default:index.html.twig', array('albums' => $albums));
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
