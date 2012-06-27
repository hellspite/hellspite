<?php

namespace Hellspite\AnnounceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('title')
            ->add('icon')
            ->add('text')
            ->add('slug')
        ;
    }

    public function getName()
    {
        return 'hellspite_announcebundle_posttype';
    }
}
