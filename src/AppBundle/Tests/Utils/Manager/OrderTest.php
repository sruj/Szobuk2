<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-07
 * Time: 14:47
 */

namespace AppBundle\Tests\Utils\Manager;

use AppBundle\Utils\Manager\Order;
use Doctrine\ORM\EntityManager;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    
    
    //todo: nie wiem. co tu testować. przecież nie będę jednostkowo testował metodę Docrine getRepository, a reszta to prywatne metody.

    protected $object;


    protected function setUp() {
        $em = $this->createMock(EntityManager::class);

        $this->object = new Order($em);

        
    }


    
    

    public function testPrepareOrder()
    {
    }
}
