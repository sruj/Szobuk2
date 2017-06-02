<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:42
 */

namespace AppBundle\Tests\Utils\Purchase;

use AppBundle\Entity\Purchase;
use AppBundle\Utils\Purchase\PurchaseManager;
use AppBundle\Entity\Client;
use AppBundle\Entity\Status;
use AppBundle\Entity\Book;
use Doctrine\Common\Collections\Collection;
use UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Doctrine\ORM\EntityManager;
use AppBundle\Event\PurchasePlacedEvent;
use AppBundle\Exception\PurchaseNotFoundException;

class PurchaseManagerTest extends \PHPUnit_Framework_TestCase
{

    public function testPlacePurchaseReturnPurchaseForGivenCart()
    {
        $em = $this->getEntityManagerMock();
        $storage = $this->getTokenStorageMock();
        $checker = $this->getAuthorizationCheckerMock();
        $session = $this->getSessionMock();
        $dispatcher = $this->getEventDispatcherMock(PurchasePlacedEvent::NAME);
        
        $obj = new PurchaseManager($em,$storage,$checker,$session,$dispatcher);
        $cart = ['111'=>'4','222'=>'3'];

        $this->assertTrue($obj->placePurchase($this->getKlientMock(),$cart));
    }


    public function testPlacePurchaseReturnExceptionForGivenCart()
    {
        $this->expectException(PurchaseNotFoundException::class);
        $em = $this->getEntityManagerMock(true);
        $storage = $this->getTokenStorageMock();
        $checker = $this->getAuthorizationCheckerMock();
        $session = $this->getSessionMock();
        $dispatcher = $this->getEventDispatcherMock(PurchasePlacedEvent::NAME);

        $obj = new PurchaseManager($em,$storage,$checker,$session,$dispatcher);
        $cart = ['111'=>'4','222'=>'3'];

        $obj->placePurchase($this->getKlientMock(),$cart);
    }



    protected function getKlientMock()
    {
        return $this->createMock(Client::class); //stub (wszystko zwraca null)
    }

    protected function getUserMock()
    {
        return $this->createMock(User::class); //stub (wszystko zwraca null)
    }

    protected function getTokenStorageMock()
    {
        $user = $this->getUserMock();

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')
            ->willReturn($user);

        $tokenStorage = $this->createMock(TokenStorage::class);
        $tokenStorage->method('getToken')
            ->willReturn($token);

        return $tokenStorage;
    }

    protected function getAuthorizationCheckerMock($returnIsGranted = true)
    {
        $authorizationChecker = $this
            ->getMockBuilder(AuthorizationCheckerInterface::class)
            ->setMethods(['isGranted'])
            ->disableOriginalConstructor()
            ->getMock();
        $authorizationChecker
            ->expects($this->any())
            ->method('isGranted')
            ->with('IS_AUTHENTICATED_FULLY')
            ->will($this->returnValue($returnIsGranted));

        return $authorizationChecker;
    }

    protected function getSessionMock()
    {
        $flashBag = $this->createMock(FlashBagInterface::class);
        $flashBag->method('add')
            ->willReturn(null);
        
        $session = $this->createMock(Session::class);
        $session->method('getFlashBag')
            ->willReturn($flashBag);

        return $session;
    }

    /**
     * codeCoverageIgnore
     */
    protected function getEventDispatcherMock($event, $once = true)
    {
        $eventDispatcherMock = $this->createMock(EventDispatcherInterface::class);

        $eventDispatcherMock->expects($once ? $this->once() : $this->never())
            ->method('dispatch')
            ->with($event);

        return $eventDispatcherMock;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getEntityManagerMock($exception=false)
    {
        $book = $this->createMock(Book::class); //stub (wszystko zwraca null)
        $status = $this->createMock(Status::class); //stub (wszystko zwraca null)
        $purchase = $this->createMock(Purchase::class);
        if($exception){$purchase=null;};

        $bookRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
        $bookRepository
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue($book));
        $statusRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
        $statusRepository
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue($status));
        $purchaseRepository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
        $purchaseRepository
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue($purchase));

        $entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['getRepository','persist','flush'])
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->withConsecutive(
                $this->equalTo('AppBundle:Status'),
                $this->equalTo('AppBundle:Book'),
                $this->equalTo('AppBundle:Book'),
                $this->equalTo('AppBundle:Purchase')
            )
            ->willReturnOnConsecutiveCalls(
                $statusRepository,
                $bookRepository,
                $bookRepository,
                $purchaseRepository
            );
        $entityManager->expects($this->any())
            ->method('persist')
            ->willReturn(null);
        $entityManager->expects($this->any())
            ->method('flush')
            ->willReturn(null);

        return $entityManager;
    }
}
