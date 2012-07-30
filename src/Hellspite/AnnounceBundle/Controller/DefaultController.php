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
        return $this->render('HellspiteAnnounceBundle:Default:index.html.twig', array('posts' => $posts, 'show' => false));
    }

    public function showAction($slug){
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteAnnounceBundle:Post')->findBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        return $this->render('HellspiteAnnounceBundle:Default:show.html.twig', array(
            'posts'      => $entity,
        ));
    }
}
