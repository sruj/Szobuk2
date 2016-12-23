<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:53
 */

namespace AppBundle\Utils\Order;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Klient;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\ZamowienieProdukt;
use AppBundle\Entity\Status;
use AppBundle\Entity\Ksiazka;
use AppBundle\Event\OrderPlacedEvent;

class OrderManager
{
    private $storage;
    private $checker;
    private $session;
    private $em;
    private $dispatcher;

    /**
     * ZamowienieManager constructor.
     */
    public function __construct(EntityManager $em,TokenStorage $storage,AuthorizationCheckerInterface $checker,Session $session,EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->storage = $storage;
        $this->checker = $checker;
        $this->session = $session;
        $this->dispatcher = $dispatcher;
    }

    public function placeOrder($klient)
    {
        if ($this->checker->isGranted('IS_AUTHENTICATED_FULLY')){
            $klient->setIdlogowanie($this->getUser());
        }

        $zamowienie = new Zamowienie();
        $zamowienie->setIdklient($klient);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $zamowienie->setIdstatus($status);
        $zamowienie->setDatazlozeniacurrent();
        
        $this->createOrderProducts($zamowienie);

        $this->em->persist($klient);
        $this->em->persist($zamowienie);
        $this->em->flush();
        $this->dispatcher->dispatch(OrderPlacedEvent::NAME, new OrderPlacedEvent($zamowienie));                                 // wysyłam maile do zarzadcy i klienta

        $this->addFlashBag($zamowienie);
    }
    
    private function getUser()
    {
        return $this->storage->getToken()->getUser();
    }

    private function createOrderProducts($zamowienie)
    {
        $cart = $this->session->get('cart');
        foreach ($cart as $isbn => $quantity)
        {
            $ksiazka = $this->em
                ->getRepository('AppBundle:Ksiazka')
                ->find($isbn);
            $zm = new ZamowienieProdukt();
            $zm->setIdzamowienie($zamowienie);
            $zm->setIsbn($ksiazka);
            $zm->setTytul($ksiazka->getTytul());
            $zm->setAutor($ksiazka->getAutor());
            $zm->setCenaproduktu($ksiazka->getCena());
            $zm->setRokwydania($ksiazka->getRokwydania());
            $zm->setIlosc($quantity);
            $this->em->persist($zm);
        }
    }
    
    private function addFlashBag($zamowienie){
        $idzamowienia = $zamowienie->getIdzamowienie();
        $this->session->getFlashBag()->add(
            'idzamowienie',
            $idzamowienia);
    }

    
}