<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('isbn', null, array('attr' => array
                        ('placeholder' => 'ISBN',), 'label' => 'ISBN',))
                ->add('title', null, array('attr' => array
                        ('placeholder' => 'Tytuł',), 'label' => 'Tytuł',))
                ->add('author', null, array('attr' => array
                        ('placeholder' => 'Autor',), 'label' => 'Autor',))
                ->add('description', null, array('attr' => array
                        ('placeholder' => 'Opis',), 'label' => 'Opis',))
                ->add('cena', null, array('attr' => array
                        ('placeholder' => 'Cena',), 'label' => 'Cena',))
                ->add('picture', null, array('attr' => array
                        ('placeholder' => 'Obrazek',), 'label' => 'Obrazek',))
                ->add('publishyear', null, array('attr' => array
                        ('placeholder' => 'Rok Wydania','min' => '1700',
                        'max' => '2200',), 'label' => 'Rok Wydania', ))
                ->add('print', null, array('attr' => array
                        ('placeholder' => 'Wydawnictwo',), 'label' => 'Wydawnictwo',))
                ->add('quantity', null, array('attr' => array
                        ('placeholder' => 'Ilość','min' => '1'),'label' => 'Ilość',))
                ->add('idcategory', null, array
                    ('placeholder' => 'Category', 'label' => 'Category', 'attr' => array('required' => true)))//dzięki temu zadziała styl szaro czarny w KsiazkaNew

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
