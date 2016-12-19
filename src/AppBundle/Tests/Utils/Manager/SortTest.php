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
    public function testGetColumnsSortOrder($columnSortOrder,$columnSort,$expected)
    {
        $object = new Sort($this->getTableDetails($columnSort, $columnSortOrder));
        $result = $object->getColumnsSortOrder();
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
            ->method('getColumnsSortOrder')
            ->will($this->returnValue($columnsSortOrder));

        return $TableDetails;
    }

    
    /**
     * @return \Generator
     */
    public function getTableConfigDetails()
    {
        yield [ 'null','idzamowienie' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield ['null','datazlozenia' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield ['null','idstatus' ,
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield ['null','idklient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [ 'ASC','idzamowienie' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'DESC']];
        yield [ 'ASC','datazlozenia' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'DESC','Numer'=>'null']];
        yield [ 'ASC','idstatus' ,
            ['Status'=>'DESC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [ 'ASC','idklient' ,
            ['Status'=>'null','Klient'=>'DESC','Data'=>'null','Numer'=>'null']];

        yield [ 'DESC','idzamowienie' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield [ 'DESC','datazlozenia' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield [ 'DESC','idstatus' ,
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [ 'DESC','idklient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [ 'BAD-IDEA','idklient' ,
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];
        yield [ 'BAD-IDEA','BAD-IDEA' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];

        yield [ false,'idklient' ,
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
    }

}
