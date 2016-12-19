<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-19
 * Time: 17:41
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\FormsManager;
use Symfony\Component\Form\FormInterface;

class FormsManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getProviderData
     */
    public function testIsAnyFormValid($isvalid, $expected)
    {
        $form = $this->createMock(FormInterface::class);
        $form->expects($this->any())
            ->method('isValid')
            ->will($this->returnValue($isvalid));
        $arrayOfObjects = [$form];

        $fm = new FormsManager($arrayOfObjects);
        $res = $fm->isAnyFormValid();
        $this->assertEquals($expected,$res);
        
    }
    
    /**
     * @codeCoverageIgnore
     */
    public function getProviderData()
    {
        yield [ false, false];
        yield [ true, true];
    }




}