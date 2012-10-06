<?php

namespace Hellspite\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('HellspiteContactBundle:Default:index.html.twig');
    }
}
