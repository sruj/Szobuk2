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
        $purchase = $this->preparePurchaseDetailsToPersistInDatabase($client);
        $this->createPurchaseProductsAndPersistInDatabase($purchase,$cart);
        $this->em->persist($client);
        $this->em->persist($purchase);
        $this->em->flush();
        $this->dispatchEventWithPurchaseToSendConfirmedEmails($purchase);
        $this->addFlashBagWithPurchaseIdVariable($purchase);
        
        if (empty($this->em->getRepository('AppBundle:Purchase')->find($purchase))){
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

        $purchase = new Purchase();
        $purchase->setIdclient($client);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $purchase->setIdstatus($status);
        $purchase->setPurchasedatecurrent();
        
        return $purchase;
    }

    /**
     * @param Purchase $purchase
     */
    private function createPurchaseProductsAndPersistInDatabase($purchase,$cart)
    {
        foreach ($cart as $isbn => $quantity)
        {
            /** @var Book $book */
            $book = $this->em
                ->getRepository('AppBundle:Book')
                ->find($isbn);
            $zm = new PurchaseProduct();
            $zm->setIdpurchase($purchase);
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
     * @param Purchase $purchase
     */
    private function addFlashBagWithPurchaseIdVariable($purchase){
        $idzamowienia = $purchase->getIdpurchase();
        $this->session->getFlashBag()->add(
            'idpurchase',
            $idzamowienia);
    }

    /**
     * @param Purchase $purchase
     */
    private function dispatchEventWithPurchaseToSendConfirmedEmails($purchase)
    {
        $this->dispatcher->dispatch(PurchasePlacedEvent::NAME, new PurchasePlacedEvent($purchase));
    }




}