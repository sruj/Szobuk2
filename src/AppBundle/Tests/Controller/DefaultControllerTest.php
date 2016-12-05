<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Ksiazka;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('a.active:contains("Wszystkie")')->count(),
            'Podstrona "Wszystkie" nie działa.');
        $this->assertCount(Ksiazka::NUM_ITEMS, $crawler->filterXPath('//div[@class=\'top-right\']'),
            'Strona nie wyświetla odpowiednią ilość produktów.(div top-right czyli tam gdzie cena)');

    }

    public function testPopularne()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/popularne');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('a.active:contains("Popularne")')->count(),
            'Podstrona "Popularne" nie działa.');
        $this->assertCount(Ksiazka::NUM_ITEMS, $crawler->filterXPath('//div[@class=\'top-right\']'),
            'Strona nie wyświetla odpowiednią ilość produktów.(div top-right czyli tam gdzie cena)');
    }

    public function testNowosci()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nowosci');

        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('a.active:contains("Nowości")')->count(),
            'Podstrona "Nowości" nie działa.');
        $this->assertCount(Ksiazka::NUM_ITEMS, $crawler->filterXPath('//div[@class=\'top-right\']'),
            'Strona nie wyświetla odpowiednią ilość produktów.(div top-right czyli tam gdzie cena)');
    }

}
