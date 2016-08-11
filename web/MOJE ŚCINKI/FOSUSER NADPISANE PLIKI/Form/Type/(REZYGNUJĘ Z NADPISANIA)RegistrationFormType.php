<?php  
// JEDNAK NIE NADPISUJĘ FORMULARZA REJESTRACJI. REZYGNUJĘ Z POWIĘKSZANIA FORMULARZA O DANE TABELI KLIENT NA TYM ETAPIE. TABELA KLIENT BĘDZIE DODAWANA NA ETAPIE FINALIZACJI ZAKUPU KSIĄŻKI.
//
//namespace My\UserBundle\Form\Type;
//
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use AppBundle\Form\KlientType;
//
//class RegistrationFormType extends AbstractType
//{
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        // add your custom field
//        $builder->add('klient', new KlientType());
//    }
//
//    public function getParent()
//    {
//        return 'fos_user_registration';
//    }
//
//    public function getName()
//    {
//        return 'my_user_registration';
//    }
//}