<?php

namespace AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DataZamType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('od', 'date', array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    ))
                ->add('do', 'date', array(
                    'input'  => 'datetime',
                    'widget' => 'choice',
                    ))
                ->add('filtruj', 'submit');
            
            ;
//        $builder
//                ->add('orderdate', 'entity', array(
//                    'class' => 'AppBundle:Purchase',
//                    'placeholder' => 'Od',
//                    'label' => false,
//                     'property' => 'orderdate',
//                ))
//                ->add('filtruj', 'submit');
//            ;
    }

//    /**
//     * @param OptionsResolverInterface $resolver
//     */
//    public function setDefaultOptions(OptionsResolverInterface $resolver) {
//        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Purchase'
//        ));
//    }

    /**
     * @return string
     */
    public function getName() {
        return 'data';
    }

}
