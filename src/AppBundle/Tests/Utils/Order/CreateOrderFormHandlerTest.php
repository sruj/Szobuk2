<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:42
 */

namespace AppBundle\Tests\Utils\Purchase;

use AppBundle\Entity\Book;
use AppBundle\Entity\Status;
use AppBundle\Utils\Purchase\CreatePurchaseFormHandler;
use AppBundle\Utils\Purchase\PurchaseManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class CreatePurchaseFormHandlerTest extends \PHPUnit_Framework_TestCase
{

    public function testhandleFormAndPlacePurchase()
    {
        $o = new CreatePurchaseFormHandler($this->getPurchaseManagerMock());
        $this->assertTrue($o->handleFormAndPlacePurchase($this->getFormInterfaceMock(),$this->getRequestMock()));
    }

    public function testhandleFormAndPlacePurchaseReturnFalseForInvalidForm()
    {
        $o = new CreatePurchaseFormHandler($this->getPurchaseManagerMock());
        $this->assertFalse($o->handleFormAndPlacePurchase($this->getFormInterfaceMock(false),$this->getRequestMock()));
    }
    
    /**
     * @expectedException \Exception
     */
    public function testhandleFormAndPlacePurchaseThrowExceptionForEmptyCart()
    {
        $o = new CreatePurchaseFormHandler($this->getPurchaseManagerMock());
        $this->assertTrue($o->handleFormAndPlacePurchase($this->getFormInterfaceMock(),$this->getRequestMock(false)));
    }


    protected function getPurchaseManagerMock($return = true)
    {
        $om = $this->createMock(PurchaseManager::class); //stub (wszystko zwraca null)
        $om->method('placePurchase')
            ->willReturn($return);

        return $om;
    }

    protected function getFormInterfaceMock($return = true)
    {
        $form = $this->createMock(FormInterface::class);
        $form->method('isValid')
            ->willReturn($return);
        return $form;
    }

    protected function getRequestMock($return = true)
    {
        $session = $this->createMock(SessionInterface::class);
        $session->method('get')
            ->willReturn($return);
        $session->method('has')
            ->willReturn($return);

        $request = $this->createMock(Request::class);
        $request->method('getSession')
            ->willReturn($session);

        return $request;
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    protected function getKlientMock()
    {
        return $this->createMock(Klient::class); //stub (wszystko zwraca null)
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
    public function getEntityManagerMock()
    {
        $book = $this->createMock(Book::class); //stub (wszystko zwraca null)
        $status = $this->createMock(Status::class); //stub (wszystko zwraca null)

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
                $this->equalTo('AppBundle:Book')
            )
            ->willReturnOnConsecutiveCalls(
                $statusRepository,
                $bookRepository,
                $bookRepository
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
