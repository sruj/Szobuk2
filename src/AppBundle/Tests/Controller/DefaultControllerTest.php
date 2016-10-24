<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Wszystkie")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("ZŁ")')->count() > 0);
        $this->assertGreaterThan(0, $crawler->filter('a.active')->count());
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("0")')->count() > 0);

    }
    
    public function testPopularne()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/popularne');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Popularne")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("ZŁ")')->count() > 0);
    }

    public function testNowosci()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nowosci');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($crawler->filter('html:contains("Nowości")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("ZŁ")')->count() > 0);
    }

//    public function testUsunFormularz()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/login');
//
//        $this->assertEquals('', $crawler->filter('form input[name=_username]')->attr('value'));
//    }

}
