<?php

namespace Hellspite\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('file', 'file')
            ->add('caption')
        ;
    }

    public function getName()
    {
        return 'photo';
    }
}
