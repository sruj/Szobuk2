<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Book;
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


        /** @var Book $book */
        $book = $em->getRepository('Book.php')->findOneBy(['tytul'=>'Accountant']);


        $menu->addChild('Accountant', array(
            'route' => 'book_show',
            'routeParameters' => array('id' => $book->getIsbn())
        ));



//        // create another menu item
//        $menu->addChild('About Me', array('route' => 'about'));
//        // you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));


        return $menu;
    }
}