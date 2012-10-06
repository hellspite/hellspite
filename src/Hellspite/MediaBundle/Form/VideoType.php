<?php

namespace Hellspite\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subtitle')
            ->add('url')
        ;
    }

    public function getName()
    {
        return 'hellspite_mediabundle_videotype';
    }
}
