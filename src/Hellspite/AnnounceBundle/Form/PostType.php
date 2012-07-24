<?php

namespace Hellspite\AnnounceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/M/yyyy'
            ))
            ->add('title')
            ->add('file', 'file')
            ->add('text')
        ;
    }

    public function getName()
    {
        return 'post';
    }
}
