<?php

namespace Hellspite\GigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $gigs = $em->getRepository('HellspiteGigBundle:Gig')->getNext(); 
        $pasts = $em->getRepository('HellspiteGigBundle:Gig')->getPast();  
        return $this->render('HellspiteGigBundle:Default:index.html.twig', array('gigs' => $gigs, 'pasts' => $pasts));
    }

    public function sideBarAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $gigs = $em->getRepository('HellspiteGigBundle:Gig')->getNext(); 
        return $this->render('HellspiteGigBundle:Default:sideBar.html.twig', array('gigs' => $gigs));
    }

    public function showAction($slug){
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HellspiteGigBundle:Gig')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gig entity.');
        }

        return $this->render('HellspiteGigBundle:Default:show.html.twig', array(
            'gig'      => $entity,
        ));
    }
}
