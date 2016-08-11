<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZamowienieListType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'zamowienia',
                'collection',
                array(
                    'type' => new \AppBundle\Form\ZamowienieType(),
                ))
            ->add('zapisz', 'submit', array('label' => 'Zapisz zmiany'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ZamowienieList'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_zamowienialist';
    }
}
