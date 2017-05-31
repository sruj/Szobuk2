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
     * @param Client $client
     * @return bool
     * @throws
     */
    public function placeOrder($client, $cart)
    {
        $order = $this->prepareOrderDetailsToPersistInDatabase($client);
        $this->createOrderProductsAndPersistInDatabase($order,$cart);
        $this->em->persist($client);
        $this->em->persist($order);
        $this->em->flush();
        $this->dispatchEventWithOrderToSendConfirmedEmails($order);
        $this->addFlashBagWithOrderIdVariable($order);
        
        if (empty($this->em->getRepository('Order.php')->find($order))){
            throw new OrderNotFoundException('Nie udało się złożyć zamówienia.');
        }
        return true;
    }

    /**
     * @param Client $client
     * @return Order
     */
    private function prepareOrderDetailsToPersistInDatabase($client)
    {
        if ($this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client->setIdlogin($this->getUser());
        }

        $order = new Order();
        $order->setIdclient($client);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $order->setIdstatus($status);
        $order->setOrderdatecurrent();
        
        return $order;
    }

    /**
     * @param Order $order
     */
    private function createOrderProductsAndPersistInDatabase($order,$cart)
    {
        foreach ($cart as $isbn => $quantity)
        {
            /** @var Book $ksiazka */
            $ksiazka = $this->em
                ->getRepository('AppBundle:Book')
                ->find($isbn);
            $zm = new OrderProduct();
            $zm->setIdorder($order);
            $zm->setIsbn($ksiazka);
            $zm->setTytul($ksiazka->getTitle());
            $zm->setAuthor($ksiazka->getAuthor());
            $zm->setCenaproduktu($ksiazka->getPrice());
            $zm->setPublishYear($ksiazka->getPublishYear());
            $zm->setQuantity($quantity);
            $this->em->persist($zm);
        }
    }

    private function getUser()
    {
        return $this->storage->getToken()->getUser();
    }
    
    /**
     * @param Order $order
     */
    private function addFlashBagWithOrderIdVariable($order){
        $idzamowienia = $order->getIdorder();
        $this->session->getFlashBag()->add(
            'idorder',
            $idzamowienia);
    }

    /**
     * @param Order $order
     */
    private function dispatchEventWithOrderToSendConfirmedEmails($order)
    {
        $this->dispatcher->dispatch(OrderPlacedEvent::NAME, new OrderPlacedEvent($order));
    }




}