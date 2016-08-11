<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KategoriaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//         było        ->add('nazwa')
                ->add('nazwa', 'text', array(
                    'attr' => array(
                        'placeholder' => 'Nazwa kategorii',
                    ),
                    'label' => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Kategoria'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'appbundle_kategoria';
    }

}
