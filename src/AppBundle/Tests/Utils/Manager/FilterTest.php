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

    public function testPrepareFilterAndQuery()
    {
        $object = new Filter();
        $res = $object->prepareFilterAndQuery(
            $this->getTableDetails(),
            $this->getFormsManagerExtended(),
            $this->getFilterQueryMock());
        $this->assertInstanceOf(TableDetails::class,$res);
    }

    protected function getTableDetails(
        $filter1 = false,
        $filter2 = 'idstatus',
        $identifier = false,
        $query = false,
        $filterField = false,
        $columnSort = null,
        $columnsSortOrder = null)
    {
        $TableDetails = $this->getMockBuilder(TableDetails::class)
            ->getMock();
        $TableDetails->expects($this->any())
            ->method('getFilter')
            ->will($this->onConsecutiveCalls($filter1,$filter2,$filter2));
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
        $isStatusFormValid = true,
        $isDataZamFormValid = false,
        $isNrKlientaFormValid = false,
        $idStatus = 3,
        $idKlient = 2,
        $od = '2015-12-25 20:12:01',
        $do = '2016-12-25 20:12:01')
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
        $FormsManagerExtended->expects($this->any())
            ->method('getIdStatusFromStatusForm')
            ->will($this->returnValue($idStatus));
        $FormsManagerExtended->expects($this->any())
            ->method('getOdFromDataZamForm')
            ->will($this->returnValue($od));
        $FormsManagerExtended->expects($this->any())
            ->method('getDoFromDataZamForm')
            ->will($this->returnValue($do));
        $FormsManagerExtended->expects($this->any())
            ->method('getIdKlientFromNrKlientaForm')
            ->will($this->returnValue($idKlient));

        return $FormsManagerExtended;
    }

    
    protected function getFilterQueryMock()
    {
        $td = new TableDetails();
        $FilterQuery = $this->getMockBuilder(FilterQuery::class)
            ->disableOriginalConstructor()
            ->getMock();
        $FilterQuery->expects($this->any())
            ->method('prepareStatusFilterQuery')
            ->will($this->returnValue($td));
        $FilterQuery->expects($this->any())
            ->method('prepareDataFilterQuery')
            ->will($this->returnValue($td));
        $FilterQuery->expects($this->any())
            ->method('prepareKlientFilterQuery')
            ->will($this->returnValue($td));
        
        return $FilterQuery;
    }
}