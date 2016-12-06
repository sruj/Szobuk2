<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KsiazkaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('isbn', null, array('attr' => array
                        ('placeholder' => 'ISBN',), 'label' => 'ISBN',))
                ->add('tytul', null, array('attr' => array
                        ('placeholder' => 'Tytuł',), 'label' => 'Tytuł',))
                ->add('autor', null, array('attr' => array
                        ('placeholder' => 'Autor',), 'label' => 'Autor',))
                ->add('opis', null, array('attr' => array
                        ('placeholder' => 'Opis',), 'label' => 'Opis',))
                ->add('cena', null, array('attr' => array
                        ('placeholder' => 'Cena',), 'label' => 'Cena',))
                ->add('obrazek', null, array('attr' => array
                        ('placeholder' => 'Obrazek',), 'label' => 'Obrazek',))
                ->add('rokwydania', null, array('attr' => array
                        ('placeholder' => 'Rok Wydania','min' => '1700',
                        'max' => '2200',), 'label' => 'Rok Wydania', ))
                ->add('wydawnictwo', null, array('attr' => array
                        ('placeholder' => 'Wydawnictwo',), 'label' => 'Wydawnictwo',))
                ->add('ilosc', null, array('attr' => array
                        ('placeholder' => 'Ilość','min' => '1'),'label' => 'Ilość',))
                ->add('idkategoria', null, array
                    ('placeholder' => 'Kategoria', 'label' => 'Kategoria', 'attr' => array('required' => true)))//dzięki temu zadziała styl szaro czarny w KsiazkaNew

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ksiazka'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'appbundle_ksiazka';
    }

}
