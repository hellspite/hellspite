<?php

namespace Hellspite\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('HellspiteMediaBundle:Default:index.html.twig');
    }
}
