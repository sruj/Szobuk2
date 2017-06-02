<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-19
 * Time: 23:12
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\TableDetails;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Utils\Manager\Purchase;

class PurchaseTest extends \PHPUnit_Framework_TestCase
{

    public function testPreparePurchaseForQueryTrue()
    {
        $purchase = new Purchase($this->getEntityManagerX());
        $res = $purchase->preparePurchase($this->getTableDetails(true));
        $expected = 'foo';

        $this->assertEquals($expected,$res);

        $res2 = $purchase->getTableDetails();
        $this->assertInstanceOf(TableDetails::class,$res2);
    }

    public function testPreparePurchaseForQueryFalse()
    {
        $purchase = new Purchase($this->getEntityManagerAll());
        $res = $purchase->preparePurchase($this->getTableDetails(false));
        $expected = 'foo';

        $this->assertEquals($expected,$res);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getTableDetails($guery)
    {
        $TableDetails = $this->getMockBuilder(TableDetails::class)
            ->getMock();

        $TableDetails->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($guery));
        $TableDetails->expects($this->any())
            ->method('getColumnSort')
            ->will($this->returnValue('foo'));
        $TableDetails->expects($this->any())
            ->method('getColumnsSortPurchase')
            ->will($this->returnValue('foo'));

        return $TableDetails;
    }


    /**
     * @codeCoverageIgnore
     */
    public function getEntityManagerX()
    {
        $queryExpectedValue = 'foo';

        $repository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findByXPurchasedByY'])
            ->getMock();

        $repository
            ->expects($this->once())
            ->method('findByXPurchasedByY')
            ->will($this->returnValue($queryExpectedValue));

        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(['getRepository'])
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('AppBundle:Purchase')
            ->will($this->returnValue($repository));

        return $entityManager;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getEntityManagerAll()
    {
        $queryExpectedValue = 'foo';

        $repository = $this
            ->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->setMethods(['findAllPurchasedByY'])
            ->getMock();

        $repository
            ->expects($this->once())
            ->method('findAllPurchasedByY')
            ->will($this->returnValue($queryExpectedValue));

        $entityManager = $this
            ->getMockBuilder('Doctrine\ORM\EntityManager')
            ->setMethods(['getRepository'])
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager
            ->expects($this->once())
            ->method('getRepository')
            ->with('AppBundle:Purchase')
            ->will($this->returnValue($repository));

        return $entityManager;
    }
    
}