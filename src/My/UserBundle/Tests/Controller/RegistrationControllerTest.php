<?php

namespace My\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{


    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
    }
}
