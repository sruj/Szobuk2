<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-19
 * Time: 22:55
 */

namespace AppBundle\Tests\Utils\Manager;


use AppBundle\Utils\Manager\TableDetails;

class TableDetailsTest extends \PHPUnit_Framework_TestCase
{
    
    
    public function testGettersAndSetters(){
        $o = new TableDetails();
        $expect = $input = 'foo';
        $o->setIdentifier($input);
        $this->assertEquals($expect,$o->getIdentifier());
        $o->setColumnsSortOrder($input);
        $this->assertEquals($expect,$o->getColumnsSortOrder());
        $o->setQuery($input);
        $this->assertEquals($expect,$o->getQuery());
        $o->setColumnSort($input);
        $this->assertEquals($expect,$o->getColumnSort());
        $o->setFilterField($input);
        $this->assertEquals($expect,$o->getFilterField());
        $o->setFilter($input);
        $this->assertEquals($expect,$o->getFilter());
    }

}