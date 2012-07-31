<?php

namespace Hellspite\GigBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('HellspiteGigBundle:Default:index.html.twig', array('name' => $name));
    }
}
