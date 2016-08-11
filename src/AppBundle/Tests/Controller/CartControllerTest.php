<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CartControllerTest extends WebTestCase
{
    public function testAddtocart()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addtocart');
    }

}
