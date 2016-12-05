<?php

namespace AppBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StatusType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('status', 'entity', array(
                    'class' => 'AppBundle:Status',
                    'placeholder' => 'Status Zamówienia',
                    'label' => false
                ))
                ->add('filtruj', 'submit');
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Status'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'status';
    }

}
