<?php

namespace Hellspite\MediaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/M/yyyy'
            ))
            ->add('title')
            ->add('subtitle')
            ->add('photos', 'collection', array(
                'type' => new PhotoType(),
                'allow_add' => true,
                'by_reference' => false,
            ))
        ;
    }

    public function getName()
    {
        return 'album';
    }
}
