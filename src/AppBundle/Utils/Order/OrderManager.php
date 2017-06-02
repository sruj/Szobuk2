<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:53
 */

namespace AppBundle\Utils\Purchase;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Client;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseProduct;
use AppBundle\Entity\Status;
use AppBundle\Entity\Book;
use AppBundle\Event\PurchasePlacedEvent;
use AppBundle\Exception\PurchaseNotFoundException;

class PurchaseManager
{
    private $storage;
    private $checker;
    private $session;
    private $em;
    private $dispatcher;

    /**
     * PurchaseManager constructor.
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
    public function placePurchase($client, $cart)
    {
        $order = $this->preparePurchaseDetailsToPersistInDatabase($client);
        $this->createPurchaseProductsAndPersistInDatabase($order,$cart);
        $this->em->persist($client);
        $this->em->persist($order);
        $this->em->flush();
        $this->dispatchEventWithPurchaseToSendConfirmedEmails($order);
        $this->addFlashBagWithPurchaseIdVariable($order);
        
        if (empty($this->em->getRepository('Purchase.php')->find($order))){
            throw new PurchaseNotFoundException('Nie udało się złożyć zamówienia.');
        }
        return true;
    }

    /**
     * @param Client $client
     * @return Purchase
     */
    private function preparePurchaseDetailsToPersistInDatabase($client)
    {
        if ($this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            $client->setIdlogin($this->getUser());
        }

        $order = new Purchase();
        $order->setIdclient($client);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $order->setIdstatus($status);
        $order->setPurchasedatecurrent();
        
        return $order;
    }

    /**
     * @param Purchase $order
     */
    private function createPurchaseProductsAndPersistInDatabase($order,$cart)
    {
        foreach ($cart as $isbn => $quantity)
        {
            /** @var Book $book */
            $book = $this->em
                ->getRepository('AppBundle:Book')
                ->find($isbn);
            $zm = new PurchaseProduct();
            $zm->setIdorder($order);
            $zm->setIsbn($book);
            $zm->setTitle($book->getTitle());
            $zm->setAuthor($book->getAuthor());
            $zm->setProductprice($book->getPrice());
            $zm->setPublishYear($book->getPublishYear());
            $zm->setQuantity($quantity);
            $this->em->persist($zm);
        }
    }

    private function getUser()
    {
        return $this->storage->getToken()->getUser();
    }
    
    /**
     * @param Purchase $order
     */
    private function addFlashBagWithPurchaseIdVariable($order){
        $idzamowienia = $order->getIdorder();
        $this->session->getFlashBag()->add(
            'idorder',
            $idzamowienia);
    }

    /**
     * @param Purchase $order
     */
    private function dispatchEventWithPurchaseToSendConfirmedEmails($order)
    {
        $this->dispatcher->dispatch(PurchasePlacedEvent::NAME, new PurchasePlacedEvent($order));
    }




}