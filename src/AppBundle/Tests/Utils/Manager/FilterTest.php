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
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\Filter\DataZamType;
use AppBundle\Form\Filter\NrKlientaType;

class FilterTest extends \PHPUnit_Framework_TestCase
{


    public function testStub()
    {

        $td = $this->createMock(TableDetails::class);
        $td->method('getColumnsSortOrder')->willReturn('');
        $td->method('getColumnSort')->willReturn('');
        $td->method('getFilterField')->willReturn('');
        $td->method('getQuery')->willReturn('');
        $td->method('getFilter')->willReturn('');
        $td->method('getIdentifier')->willReturn('');

        $forms['StatusForm'] = $this->createMock(StatusType::class);
        $forms['StatusForm']->method('isValid')->willReturn(true);
        $forms['StatusForm']->method('getIdstatus')->willReturn(true);
        $forms['DataZamForm'] = $this->createMock(DataZamType::class);
        $forms['DataZamForm']->method('isValid')->willReturn(false);
        $forms['NrKlientaForm'] = $this->createMock(NrKlientaType::class);
        $forms['NrKlientaForm']->method('isValid')->willReturn(false);

        $fq;




        $filter = new Filter();

        $this->assertEquals('foo', $filter->prepareFilterAndQuery($td,$forms,$fq));
    }
    
    


}