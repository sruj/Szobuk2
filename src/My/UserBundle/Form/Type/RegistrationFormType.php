<?php

namespace My\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', 
                    array('attr' => array('placeholder' => 'E-mail',), 'label' => false,)
                 )
            ->add('username', null, 
                    array('attr' => array('placeholder' => 'Nazwa użytkownika',), 'label' => false,)
                 )
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('attr' => array('placeholder' => 'Hasło',), 'label' => false,),
                'second_options' => array('attr' => array('placeholder' => 'Powtórz Hasło',), 'label' => false,),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            
        ;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'My\UserBundle\Entity\User',
            'intention'  => 'registration',
        ));
    }
    public function getName()
    {
        return 'my_user_registration';
    }
}