<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-11
 * Time: 00:02
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\Filter;
use AppBundle\Utils\Manager\TableDetails;
use AppBundle\Utils\Manager\FilterQuery;
use AppBundle\Utils\Manager\FormsManagerExtended;

class FilterTest extends \PHPUnit_Framework_TestCase
{

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForValidStatusFilter()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('idstatus'),
            $this->getFormsManagerExtended(true,true),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }


    public function testPrepareFilterAndQueryReturnExceptionForInvalidInstance()
    {
        $this->expectException(\Exception::class);
        $object = new Filter();
        $object->prepareFilterAndQuery(
            $this->getTableDetails('idstatus'),
            $this->getFormsManagerExtended(true,true),
            $this->getFilterQueryMock(null));
    }


    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForDataFilter()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('data'),
            $this->getFormsManagerExtended(true,false,true),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForKlientFilter()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('idklient'),
            $this->getFormsManagerExtended(true,false,false,true),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForNoFilter()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('idklient'),
            $this->getFormsManagerExtended(),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForFilterFieldAlreadySetted()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('idklient','idklient',false,false,'idklient'),
            $this->getFormsManagerExtended(),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsForFilterAlreadyMadeButChangeingSort()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('idklient',false,false,false,'idklient'),
            $this->getFormsManagerExtended(false),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    public function testPrepareFilterAndQueryReturnInstanceOfTableDetailsFilterAlreadyMadeButChangeingSort()
    {
        $object = new Filter();
        $td = new TableDetails();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails('all'),
            $this->getFormsManagerExtended(false),
            $this->getFilterQueryMock($td));
        $this->assertInstanceOf(TableDetails::class,$res);
    }
    
    protected function getTableDetails(
        $filter1 = false,
        $filter2 = false,
        $identifier = false,
        $query = false,
        $filterField = false,
        $columnSort = null,
        $columnsSortOrder = null)
    {
        $TableDetails = $this->createMock(TableDetails::class);
        $TableDetails->expects($this->any())
            ->method('getFilter')
            ->will($this->onConsecutiveCalls($filter2,$filter1,$filter1,$filter1,$filter1,$filter1));
        $TableDetails->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($query));
        $TableDetails->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue($identifier));
        $TableDetails->expects($this->any())
            ->method('getColumnsSortOrder')
            ->will($this->returnValue($columnsSortOrder));
        $TableDetails->expects($this->any())
            ->method('getColumnSort')
            ->will($this->returnValue($columnSort));
        $TableDetails->expects($this->any())
            ->method('getFilterField')
            ->will($this->returnValue($filterField));

        return $TableDetails;
    }
    

    protected function getFormsManagerExtended(
        $isAnyValid = true,
        $isStatusFormValid = false,
        $isDataZamFormValid = false,
        $isNrKlientaFormValid = false
    )
    {
        $FormsManagerExtended = $this->getMockBuilder(FormsManagerExtended::class)
            ->disableOriginalConstructor()
            ->getMock();
        $FormsManagerExtended->expects($this->any())
            ->method('isAnyFormValid')
            ->will($this->returnValue($isAnyValid));
        $FormsManagerExtended->expects($this->any())
            ->method('isStatusFormValid')
            ->will($this->returnValue($isStatusFormValid));
        $FormsManagerExtended->expects($this->any())
            ->method('isDataZamFormValid')
            ->will($this->returnValue($isDataZamFormValid));
        $FormsManagerExtended->expects($this->any())
            ->method('isNrKlientaFormValid')
            ->will($this->returnValue($isNrKlientaFormValid));

        return $FormsManagerExtended;
    }

    
    protected function getFilterQueryMock($returnValue)
    {
        $FilterQuery = $this->getMockBuilder(FilterQuery::class)
            ->getMock();
        $FilterQuery->expects($this->any())
            ->method('prepareStatusFilterQuery')
            ->will($this->returnValue($returnValue));
        $FilterQuery->expects($this->any())
            ->method('prepareDataFilterQuery')
            ->will($this->returnValue($returnValue));
        $FilterQuery->expects($this->any())
            ->method('prepareKlientFilterQuery')
            ->will($this->returnValue($returnValue))
            ->with($this->isInstanceOf(TableDetails::class))
        ;
        
        return $FilterQuery;
    }
}