<?php

namespace AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NrKlientaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('idklient', 'entity', array(
                    'class' => 'AppBundle:Klient',
                    'placeholder' => 'Nr klienta',
                    'label' => false,
                    'property' => 'idklient',
                ))
                ->add('filtruj', 'submit');
            ;
    }
//
//    /**
//     * @param OptionsResolverInterface $resolver
//     */
//    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Klient'
//        ));
//    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('registration'),
        ));
    }
    /**
     * @return string
     */
    public function getName() {
        return 'idklient';
    }

}
