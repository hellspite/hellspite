<?php

namespace Hellspite\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hellspite\ContactBundle\Entity\Mail;
use Hellspite\ContactBundle\Form\MailType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(new MailType(), $mail);

        if($request->isMethod('POST')){
            $form->bind($request);

            if($form->isValid()){
                //TODO: inserire flash message

                $data = $form->getData();

                $message = \Swift_Message::newInstance()
                    ->setSubject('Message from Hellspite.com by '.$data->getName())
                    ->setFrom($data->getEmail())
                    ->setTo('vegan.emiliano@gmail.com')
                    ->setBody($data->getText())
                ;

                $this->get('mailer')->send($message);
            }
        }

        return $this->render('HellspiteContactBundle:Default:index.html.twig', array('form' => $form->createView()));
    }
}
