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
use AppBundle\Entity\Client;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProduct;
use AppBundle\Entity\Status;
use AppBundle\Entity\Book;
use AppBundle\Event\OrderPlacedEvent;
use AppBundle\Exception\OrderNotFoundException;

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

    /**
     * @param Client $klient
     * @return bool
     * @throws
     */
    public function placeOrder($klient, $cart)
    {
        $zamowienie = $this->prepareOrderDetailsToPersistInDatabase($klient);
        $this->createOrderProductsAndPersistInDatabase($zamowienie,$cart);
        $this->em->persist($klient);
        $this->em->persist($zamowienie);
        $this->em->flush();
        $this->dispatchEventWithOrderToSendConfirmedEmails($zamowienie);
        $this->addFlashBagWithOrderIdVariable($zamowienie);
        
        if (empty($this->em->getRepository('Order.php')->find($zamowienie))){
            throw new OrderNotFoundException('Nie udało się złożyć zamówienia.');
        }
        return true;
    }

    /**
     * @param Client $klient
     * @return Order
     */
    private function prepareOrderDetailsToPersistInDatabase($klient)
    {
        if ($this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $klient->setIdlogowanie($this->getUser());
        }

        $zamowienie = new Order();
        $zamowienie->setIdklient($klient);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $zamowienie->setIdstatus($status);
        $zamowienie->setDatazlozeniacurrent();
        
        return $zamowienie;
    }

    /**
     * @param Order $zamowienie
     */
    private function createOrderProductsAndPersistInDatabase($zamowienie,$cart)
    {
        foreach ($cart as $isbn => $quantity)
        {
            $ksiazka = $this->em
                ->getRepository('Book.php')
                ->find($isbn);
            $zm = new OrderProduct();
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

    private function getUser()
    {
        return $this->storage->getToken()->getUser();
    }
    
    /**
     * @param Order $zamowienie
     */
    private function addFlashBagWithOrderIdVariable($zamowienie){
        $idzamowienia = $zamowienie->getIdzamowienie();
        $this->session->getFlashBag()->add(
            'idorder',
            $idzamowienia);
    }

    /**
     * @param Order $zamowienie
     */
    private function dispatchEventWithOrderToSendConfirmedEmails($zamowienie)
    {
        $this->dispatcher->dispatch(OrderPlacedEvent::NAME, new OrderPlacedEvent($zamowienie));
    }




}