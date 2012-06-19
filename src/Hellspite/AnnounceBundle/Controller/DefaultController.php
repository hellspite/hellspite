<?php

namespace Hellspite\AnnounceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HellspiteAnnounceBundle:Default:index.html.twig', array('name' => $name));
    }
}
