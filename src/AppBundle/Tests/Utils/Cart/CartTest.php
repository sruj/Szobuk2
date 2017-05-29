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
use AppBundle\Entity\Ksiazka;

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
            ['isbn'=>'111','tytul'=>'foo1','autor'=>'bar1','cena'=>'1111','quantity'=>'1'],
            ['isbn'=>'222','tytul'=>'foo2','autor'=>'bar2','cena'=>'2222','quantity'=>'1']
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
            ['isbn'=>'111','tytul'=>'foo1','autor'=>'bar1','cena'=>'1111',],
            ['isbn'=>'222','tytul'=>'foo2','autor'=>'bar2','cena'=>'2222']
        ];

        $ks = $this->getMockBuilder(Ksiazka::class)
            ->setMethods(['getIsbn','getTytul','getAutor','getCena'])
            ->getMock();
        $ks->expects($this->any())
            ->method('getIsbn')
            ->will($this->onConsecutiveCalls($a[0]['isbn'],$a[1]['isbn']));
        $ks->expects($this->any())
            ->method('getTytul')
            ->will($this->onConsecutiveCalls($a[0]['tytul'],$a[1]['tytul']));
        $ks->expects($this->any())
            ->method('getAutor')
            ->will($this->onConsecutiveCalls($a[0]['autor'],$a[1]['autor']));
        $ks->expects($this->any())
            ->method('getCena')
            ->will($this->onConsecutiveCalls($a[0]['cena'],$a[1]['cena']));

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
            ->with('AppBundle:Ksiazka')
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
