<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Ksiazka;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'index'));

        $em = $this->container->get('doctrine')->getManager();


        /** @var Ksiazka $book */
        $book = $em->getRepository('AppBundle:Ksiazka')->findOneBy(['tytul'=>'Accountant']);


        $menu->addChild('Accountant', array(
            'route' => 'ksiazka_show',
            'routeParameters' => array('id' => $book->getIsbn())
        ));



//        // create another menu item
//        $menu->addChild('About Me', array('route' => 'about'));
//        // you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));


        return $menu;
    }
}