<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KsiazkaIloscType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ilosc', null, array('label' => false,'attr' => array('min' => '0',
                        'max' => '99',)))
            ;
//        $builder
//            ->add('isbn',null,array('attr' => array
//                ('placeholder' => 'ISBN',),'label' => false,))
//            ->add('tytul',null,array('attr' => array
//                ('placeholder' => 'Tytuł',),'label' => false,))
//            ->add('autor',null,array('attr' => array
//                ('placeholder' => 'Autor',),'label' => false,))
//            ->add('opis',null,array('attr' => array
//                ('placeholder' => 'Opis',),'label' => false,))
//            ->add('cena',null,array('attr' => array
//                ('placeholder' => 'Cena',),'label' => false, ))
//            ->add('obrazek',null,array('attr' => array
//                ('placeholder' => 'Obrazek',),'label' => false,))
//            ->add('wydawnictwo',null,array('attr' => array
//                ('placeholder' => 'Wydawnictwo',),'label' => false,))
//            ->add('rokwydania',null,array('attr' => array
//                ('placeholder' => 'Rok Wydania',),'label' => false,))
////            ->add('idkategoria', null, array
////                ('placeholder' => 'Kategoria','label' => false,))
//            ->add('idkategoria', null, array
//                ('placeholder' => 'Kategoria','label' => false,'attr'=> array('required'=>true)))//dzięki temu zadziała styl szaro czarny w KsiazkaNew
//        
//            ;
    }
   
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Ksiazka'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_ksiazka';
    }
}
