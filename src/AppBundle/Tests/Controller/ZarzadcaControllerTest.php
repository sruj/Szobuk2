<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZarzadcaControllerTest extends WebTestCase
{
    public function testPanel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/panel');
    }

}
