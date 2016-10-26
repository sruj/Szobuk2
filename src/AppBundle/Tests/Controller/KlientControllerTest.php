<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KlientControllerTest extends WebTestCase
{
    public function testHistoriapanel()
    {
        //refaktor: Type error: Argument 2 passed to Doctrine\ORM\EntityRepository::__construct() must be an instance of Doctrine\ORM\Mapping\ClassMetadata, none given, called in C:\wamp64\www\Szobuk2\app\cache\dev\appDevDebugProjectContainer.php on line 455
        //500 Internal Server Error - FatalThrowableError
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'chinczyk',
            'PHP_AUTH_PW' => 'hinolp9',
        ]);

        $crawler = $client->request('GET', '/historiaPanel');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /kategoria/");
    }

}
