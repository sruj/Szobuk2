<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DostawaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('imie')
                ->add('nazwisko')
                ->add('email')
                ->add('ulica')
                ->add('nrDomu')
                ->add('nrMieszkania')
                ->add('kodPocztowy')
                ->add('miasto')
                ->add('nip')
                ->add('nrTelefonu')
                ->add('zapisz', 'submit');
    }

    public function getName() {
        return 'dostawa';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Klient',
        ));
    }
}
