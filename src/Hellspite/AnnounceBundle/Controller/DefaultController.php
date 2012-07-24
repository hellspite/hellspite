<?php

namespace Hellspite\AnnounceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $posts = $em->getRepository('HellspiteAnnounceBundle:Post')->getLatest(); 
        return $this->render('HellspiteAnnounceBundle:Default:index.html.twig', array('posts' => $posts));
    }
}
