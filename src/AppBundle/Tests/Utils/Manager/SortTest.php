<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:47
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\Sort;

/**
 * Class SortTest
 * @package AppBundle\Tests\Utils\Manager
 */
class SortTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getTableConfigDetails
     */
    public function testGetColumnsSortOrder($tableConfigDetails,$expected)
    {
        $object = new Sort($tableConfigDetails);
        $this->assertEquals($expected,$object->getColumnsSortOrder());
    }


    /**
     * @return \Generator
     */
    public function getTableConfigDetails()
    {
        yield [['columnsSortOrder' => 'null','columnSort'=>'idzamowienie' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield [['columnsSortOrder' =>'null','columnSort'=>'datazlozenia' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield [['columnsSortOrder' =>'null','columnSort'=>'idstatus' ],
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [['columnsSortOrder' =>'null','columnSort'=>'idklient' ],
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [['columnsSortOrder' => 'ASC','columnSort'=>'idzamowienie' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'DESC']];
        yield [['columnsSortOrder' => 'ASC','columnSort'=>'datazlozenia' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'DESC','Numer'=>'null']];
        yield [['columnsSortOrder' => 'ASC','columnSort'=>'idstatus' ],
            ['Status'=>'DESC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [['columnsSortOrder' => 'ASC','columnSort'=>'idklient' ],
            ['Status'=>'null','Klient'=>'DESC','Data'=>'null','Numer'=>'null']];

        yield [['columnsSortOrder' => 'DESC','columnSort'=>'idzamowienie' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];
        yield [['columnsSortOrder' => 'DESC','columnSort'=>'datazlozenia' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'ASC','Numer'=>'null']];
        yield [['columnsSortOrder' => 'DESC','columnSort'=>'idstatus' ],
            ['Status'=>'ASC','Klient'=>'null','Data'=>'null','Numer'=>'null']];
        yield [['columnsSortOrder' => 'DESC','columnSort'=>'idklient' ],
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];

        yield [['columnsSortOrder' => 'BAD-IDEA','columnSort'=>'idklient' ],
            ['Status'=>'null','Klient'=>'ASC','Data'=>'null','Numer'=>'null']];
        yield [['columnsSortOrder' => 'BAD-IDEA','columnSort'=>'BAD-IDEA' ],
            ['Status'=>'null','Klient'=>'null','Data'=>'null','Numer'=>'ASC']];



    }

}
