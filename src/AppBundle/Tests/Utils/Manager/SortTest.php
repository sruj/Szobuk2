<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:47
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\Sort;
use AppBundle\Utils\Manager\TableDetails;

/**
 * Class SortTest
 * @package AppBundle\Tests\Utils\Manager
 */
class SortTest extends \PHPUnit_Framework_TestCase
{
    
    /**
     * @dataProvider getTableConfigDetails
     */
    public function testGetColumnsSortPurchase($columnSortPurchase,$columnSort,$expected)
    {
        $object = new Sort($this->getTableDetails($columnSort, $columnSortPurchase));
        $result = $object->getColumnsSortPurchase();
        $this->assertEquals( $expected, $result );
    }


    /**
     * @codeCoverageIgnore
     */
    protected function getTableDetails($columnSort = null,$columnsSortOrder = null)
    {
        $TableDetails = $this->createMock(TableDetails::class);

        $TableDetails->expects($this->any())
            ->method('getColumnSort')
            ->will($this->returnValue($columnSort));
        $TableDetails->expects($this->any())
            ->method('getColumnsSortPurchase')
            ->will($this->returnValue($columnsSortOrder));

        return $TableDetails;
    }

    
    /**
     * @codeCoverageIgnore
     * @return \Generator
     */
    public function getTableConfigDetails()
    {
        yield [ 'null','idpurchase' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield ['null','purchasedate' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield ['null','idstatus' ,
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield ['null','idclient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [ 'ASC','idpurchase' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'DESC']];
        yield [ 'ASC','purchasedate' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'DESC','Numer'=>'null']];
        yield [ 'ASC','idstatus' ,
            ['Status'=>'DESC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [ 'ASC','idclient' ,
            ['Status'=>'null','Klient'=>'DESC','Data'=>'null','Numer'=>'null']];

        yield [ 'DESC','idpurchase' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield [ 'DESC','purchasedate' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield [ 'DESC','idstatus' ,
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [ 'DESC','idclient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [ 'BAD-IDEA','idclient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];
        yield [ 'BAD-IDEA','BAD-IDEA' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];

        yield [ false,'idclient' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
    }

}
