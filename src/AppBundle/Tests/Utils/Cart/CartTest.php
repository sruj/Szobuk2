<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:42
 */

namespace AppBundle\Tests\Utils\Cart;

use AppBundle\Utils\Cart\Cart;
use Symfony\Component\HttpFoundation\Session\Session;

class CartTest extends \PHPUnit_Framework_TestCase
{

    public function testAddProductToCartForSessionHasNoCart()
    {
        $session = $this->getMockBuilder(Session::class)
            ->getMock();

        $session->expects($this->any())
            ->method('has')
            ->withAnyParameters()
            ->will($this->returnValue(false));
        $session->expects($this->any())
            ->method('get')
            ->withAnyParameters()
            ->will($this->returnValue(['foo'=>1]));

        $obj = new Cart($session);
        $this->assertTrue($obj->addProductToCart('foo'));
    }


    public function testAddProductToCartForSessionHasCartWithSameProduct()
    {
        $session = $this->getMockBuilder(Session::class)
            ->getMock();

        $session->expects($this->any())
            ->method('has')
            ->withAnyParameters()
            ->will($this->returnValue(true));
        $session->expects($this->any())
            ->method('get')
            ->withAnyParameters()
            ->will($this->onConsecutiveCalls(['foo'=>1],['foo'=>2]));

        $obj = new Cart($session);
        $this->assertTrue($obj->addProductToCart('foo'));
    }


    public function testAddProductToCartForSessionHasCartWithNewProduct()
    {
        $session = $this->getMockBuilder(Session::class)
            ->getMock();

        $session->expects($this->any())
            ->method('has')
            ->withAnyParameters()
            ->will($this->returnValue(true));
        $session->expects($this->any())
            ->method('get')
            ->withAnyParameters()
            ->will($this->onConsecutiveCalls(['bar'=>1],['bar'=>1,'foo'=>1]));

        $obj = new Cart($session);
        $this->assertTrue($obj->addProductToCart('foo'));
    }

    
    public function testGetCartQuantity()
    {
        $session = $this->getMockBuilder(Session::class)
            ->getMock();

        $session->expects($this->any())
            ->method('has')
            ->withAnyParameters()
            ->will($this->returnValue(true));
        $session->expects($this->any())
            ->method('get')
            ->withAnyParameters()
            ->will($this->returnValue(['bar'=>1,'foo'=>3]));

        $obj = new Cart($session);
        $this->assertEquals(4,$obj->getCartQuantity());
    }

    public function testSessionInvalidate()
    {
        $session = $this->getMockBuilder(Session::class)
            ->getMock();

        $session->expects($this->any())
            ->method('invalidate')
            ->withAnyParameters()
            ->will($this->returnValue(true));

        $obj = new Cart($session);
        $this->assertTrue($obj->sessionInvalidate());
    }
    
    
}
