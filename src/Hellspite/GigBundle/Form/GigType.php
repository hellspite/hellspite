<?php

namespace Hellspite\GigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GigType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('venue')
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/M/yyyy'
            ))
            ->add('text')
            ->add('file', 'file')
        ;
    }

    public function getName()
    {
        return 'gig';
    }
}
