<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookListType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'ksiazki',
                'collection',
                array(
                    'type' => new \AppBundle\Form\BookQuantityType(),
                ))
            ->add('zapisz', 'submit', array('label' => 'Zapisz zmiany'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BookList'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_ksiazkilist';
    }
}
