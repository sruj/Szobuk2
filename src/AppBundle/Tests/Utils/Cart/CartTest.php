<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:42
 */

namespace AppBundle\Tests\Utils\Cart;

use AppBundle\Utils\Cart\Cart;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Book;

class CartTest extends \PHPUnit_Framework_TestCase
{

    public function testAddProductToCartForCartNotInSessionYet()
    {
        $cart = null;
        $isbn = '123456789';
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->addProductToCart($isbn,$cart);
        $expected = ['123456789' => 1];
        $this->assertEquals( $expected, $res );
    }

    public function testAddProductToCartForProductNotInCartAlready()
    {
        $cart = ['987654321'=>2];
        $isbn = '123456789';
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->addProductToCart($isbn,$cart);
        $expected = ['987654321'=>2,'123456789' => 1];
        $this->assertEquals( $expected, $res );
    }

    public function testAddProductToCartForProductInCartAlready()
    {
        $cart = ['123456789' => 1, '987654321'=>2];
        $isbn = '123456789';
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->addProductToCart($isbn,$cart);
        $expected = ['123456789' => 2, '987654321'=>2];
        $this->assertEquals( $expected, $res );
    }

    public function testRemoveProductFromCartForValidIsbnReturnUpdatedCart()
    {
        $cart = ['123456789' => 2, '987654321'=>2];
        $isbn = '123456789';
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->removeProductFromCart($isbn,$cart);
        $expected = ['987654321'=>2];
        $this->assertEquals( $expected, $res );
    }

    public function testRemoveProductFromCartForInvalidIsbnReturnException()
    {
        $this->expectException(\Exception::class);
        $cart = ['987654321'=>2];
        $isbn = '123456789';
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $obj->removeProductFromCart($isbn,$cart);
    }

    public function testGetNumerOfProductsInCart()
    {
        $cart = ['123456789' => 2, '987654321'=>2];
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->getNumberOfProductsInCart($cart);
        $expected = 4;
        $this->assertEquals( $expected, $res );
    }

    /**
     * @dataProvider getDataForPrepareRoute
     */
    public function testPrepareRoute($authorization,$expected)
    {
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->prepareRoute($authorization);
        $this->assertEquals( $expected, $res );
    }

    public function testGetAllBooksFromCartDetails()
    {
        $cart = ['111'=>'1','222'=>'1'];
        $expected = [
            ['isbn'=>'111','title'=>'foo1','author'=>'bar1','price'=>'1111','quantity'=>'1'],
            ['isbn'=>'222','title'=>'foo2','author'=>'bar2','price'=>'2222','quantity'=>'1']
        ];
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->getAllBooksFromCartDetails($cart);
        $this->assertEquals( $expected, $res );
    }

    public function testGetSumOfAllProductsInCart()
    {
        $cart = ['123456789' => 2, '987654321'=>2];
        $em = $this->getEntityManager();
        $obj = new Cart($em);
        $res = $obj->getSumOfAllProductsInCart($cart);
        $expected = 6666;
        $this->assertEquals( $expected, $res );

    }


    /**
     * @codeCoverageIgnore
     */
    public function getEntityManager()
    {
        $a = [
            ['isbn'=>'111','title'=>'foo1','author'=>'bar1','price'=>'1111',],
            ['isbn'=>'222','title'=>'foo2','author'=>'bar2','price'=>'2222']
        ];

        $ks = $this->getMockBuilder(Book::class)
            ->setMethods(['getIsbn','getTitle','getAuthor','getCena'])
            ->getMock();
        $ks->expects($this->any())
            ->method('getIsbn')
            ->will($this->onConsecutiveCalls($a[0]['isbn'],$a[1]['isbn']));
        $ks->expects($this->any())
            ->method('getTitle')
            ->will($this->onConsecutiveCalls($a[0]['title'],$a[1]['title']));
        $ks->expects($this->any())
            ->method('getAuthor')
            ->will($this->onConsecutiveCalls($a[0]['author'],$a[1]['author']));
        $ks->expects($this->any())
            ->method('getCena')
            ->will($this->onConsecutiveCalls($a[0]['price'],$a[1]['price']));

        $repository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();
        $repository
            ->expects($this->any())
            ->method('find')
            ->will($this->returnValue($ks));

        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(['getRepository'])
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->with('AppBundle:Book')
            ->will($this->returnValue($repository));

        return $entityManager;
    }

    /**
     * @codeCoverageIgnore
     * @return \Generator
     */
    public function getDataForPrepareRoute()
    {
        yield ['zaloguj', 'fos_user_security_login',];
        yield ['zarejestruj', 'fos_user_registration_register',];
    }

}
