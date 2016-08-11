<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KlientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie')
            ->add('nazwisko')
            ->add('email')
            ->add('ulica')
            ->add('nrdomu')
            ->add('nrmieszkania')
            ->add('kodpocztowy')
            ->add('miasto')
            ->add('nip')
            ->add('nrtelefonu')
        ;
    }
    
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Klient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_klient';
    }
}
