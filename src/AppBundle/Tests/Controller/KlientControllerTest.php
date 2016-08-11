<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KlientControllerTest extends WebTestCase
{
    public function testHistoriapanel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/historiaPanel');
    }

}
