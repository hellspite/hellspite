<?php

namespace Hellspite\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('HellspiteMainBundle:Default:index.html.twig');
    }
}
