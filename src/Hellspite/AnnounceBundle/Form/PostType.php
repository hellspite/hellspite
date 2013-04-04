<?php

namespace Hellspite\AnnounceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use A2lix\DemoTranslationBundle\Form\CategoryType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/M/yyyy'
            ))
            ->add('title_en')
            ->add('title_it')
            ->add('file', 'file')
            ->add('text_en', 'textarea')
            ->add('text_it', 'textarea')
        ;
    }

    public function getName()
    {
        return 'post';
    }
}
