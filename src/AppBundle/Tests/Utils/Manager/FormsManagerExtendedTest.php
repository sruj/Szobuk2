<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-14
 * Time: 12:20
 */

namespace AppBundle\Tests\Utils\Manager;


use AppBundle\Utils\Manager\Filter;
use AppBundle\Utils\Manager\FormsManagerExtended;

class FormsManagerExtendedTest extends \PHPUnit_Framework_TestCase
{
    //todo: testy są tylko dla pozytywnych scenariuszy
    

    /**
     * @var FormsManagerExtended
     */
    private $object;


    protected function setUp()
    {
        $StatusForm = $this->getMockBuilder(\Symfony\Component\Form\Form::class)
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'getData', 'getIdstatus','isValid'))
            ->getMock();
        $StatusForm->expects($this->any())
            ->method('get')
            ->will($this->returnSelf());
        $StatusForm->expects($this->any())
            ->method('getData')
            ->will($this->returnSelf());
        $StatusForm->expects($this->any())
            ->method('getIdstatus')
            ->will($this->returnValue('3'));
        $StatusForm->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $DataZamForm = $this->getMockBuilder(\Symfony\Component\Form\Form::class)
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'getData', 'format','isValid'))
            ->getMock();
        $DataZamForm->expects($this->any())
            ->method('get')
            ->will($this->returnSelf());
        $DataZamForm->expects($this->any())
            ->method('getData')
            ->will($this->returnSelf());
        $DataZamForm->expects($this->any())
            ->method('format')
            ->will($this->returnValue('2016'));
        $DataZamForm->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $NrKlientaForm = $this->getMockBuilder(\Symfony\Component\Form\Form::class)
            ->disableOriginalConstructor()
            ->setMethods(array('get', 'getData', 'getIdklient','isValid'))
            ->getMock();
        $NrKlientaForm->expects($this->any())
            ->method('get')
            ->will($this->returnSelf());
        $NrKlientaForm->expects($this->any())
            ->method('getData')
            ->will($this->returnSelf());
        $NrKlientaForm->expects($this->any())
            ->method('getIdklient')
            ->will($this->returnValue('2'));
        $NrKlientaForm->expects($this->any())
            ->method('isValid')
            ->willReturn(true);

        $tmpForms = [
            'StatusForm' => $StatusForm,
            'DataZamForm' => $DataZamForm,
            'NrKlientaForm' => $NrKlientaForm,
        ];

        $this->object = new FormsManagerExtended($tmpForms);
    }

    public function testIsAnyFormValid(){
        $this->assertTrue($this->object->isAnyFormValid());
    }

    public function testIsStatusFormValid(){
        $this->assertTrue($this->object->isStatusFormValid());
    }

    public function testIsDataZamFormValid(){
        $this->assertTrue($this->object->isDataZamFormValid());
    }

    public function testIsNrKlientaFormValid(){
        $this->assertTrue($this->object->isNrKlientaFormValid());
    }

    public function testGetIdStatusFromStatusForm(){
        $this->assertEquals('3',$this->object->getIdStatusFromStatusForm());
    }

    public function testGetOdFromDataZamForm(){
        $this->assertEquals('2016',$this->object->getOdFromDataZamForm());
    }

    public function testGetDoFromDataZamForm(){
        $this->assertEquals('2016',$this->object->getDoFromDataZamForm());
    }

    public function testGetIdKlientFromNrKlientaForm(){
        $this->assertEquals('2',$this->object->getIdKlientFromNrKlientaForm());
    }













}