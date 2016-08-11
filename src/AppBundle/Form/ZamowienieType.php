<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZamowienieType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //wykorzystywane w panelsortAction w tabeli do zmiany statusu zamówienia
        $builder
                ->add('idstatus', null, array('label' => false));
//                ->add('idzamowienie','hidden');
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Zamowienie'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zamowienie';
    }
}
