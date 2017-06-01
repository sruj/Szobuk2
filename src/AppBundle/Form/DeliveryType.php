<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeliveryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('surname')
                ->add('email')
                ->add('street')
                ->add('houseNumber')
                ->add('apartmentNumber')
                ->add('postalCode')
                ->add('city')
                ->add('nip')
                ->add('phoneNumber')
                ->add('zapisz', 'submit');
    }

    public function getName() {
        return 'dostawa';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Client',
        ));
    }
}
