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
//}     $builder
//                ->add('imie', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('nazwisko', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('email', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('ulica', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('nrDomu', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('nrMieszkania', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('kodPocztowy', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('miasto', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('nip', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('nrTelefonu', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,))
//                ->add('save', 'submit', 
//                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,));










