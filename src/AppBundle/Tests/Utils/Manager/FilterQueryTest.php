<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-19
 * Time: 13:30
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\FilterQuery;
use AppBundle\Utils\Manager\FormsManagerExtended;
use AppBundle\Utils\Manager\TableDetails;

class FilterQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTableConfigDetailsForPrepareStatusFilterQuery
     */
    public function testPrepareStatusFilterQueryReturnInstanceOfTableDetailsForValidInput($query,$identifier,$expected)
    {
        $fq = new FilterQuery();
        $res = $fq->prepareStatusFilterQuery(
            $this->getTableDetails($query,$identifier),
            $this->getFormsManagerExtended());

        $this->assertInstanceOf($expected,$res);
    }

    /**
     * @dataProvider getTableConfigDetailsForPrepareDataFilterQuery
     */
    public function testPrepareDataFilterQueryReturnInstanceOfTableDetailsForValidInput($query,$expected)
    {
        $fq = new FilterQuery();
        $res = $fq->prepareDataFilterQuery(
            $this->getTableDetails($query),
            $this->getFormsManagerExtended());

        $this->assertInstanceOf($expected,$res);
    }

    /**
     * @dataProvider getTableConfigDetailsForPrepareKlientFilterQuery
     */
    public function testPrepareKlientFilterQueryReturnInstanceOfTableDetailsForValidInput($query,$identifier,$expected)
    {
        $fq = new FilterQuery();
        $res = $fq->prepareKlientFilterQuery(
            $this->getTableDetails($query,$identifier),
            $this->getFormsManagerExtended());

        $this->assertInstanceOf($expected,$res);
    }

    /**
     * @return \Generator
     */
    public function getTableConfigDetailsForPrepareStatusFilterQuery()
    {
        $expected = TableDetails::class;

        yield [ false, false, $expected];
        yield [ false, true, $expected];
        yield [ true, true, $expected];
    }

    /**
     * @return \Generator
     */
    public function getTableConfigDetailsForPrepareDataFilterQuery()
    {
        $expected = TableDetails::class;

        yield [ false,  $expected];
        yield [ true,  $expected];
    }

    /**
     * @return \Generator
     */
    public function getTableConfigDetailsForPrepareKlientFilterQuery()
    {
        $expected = TableDetails::class;

        yield [ false, false, $expected];
        yield [ false, true, $expected];
        yield [ true, true, $expected];
    }

    protected function getTableDetails($query = false,$identifier = false)
    {
        $TableDetails = $this->createMock(TableDetails::class);
        $TableDetails->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($query));
        $TableDetails->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue($identifier));

        return $TableDetails;
    }




    protected function getFormsManagerExtended()
    {
        $FormsManagerExtended = $this->getMockBuilder(FormsManagerExtended::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $FormsManagerExtended;
    }



}