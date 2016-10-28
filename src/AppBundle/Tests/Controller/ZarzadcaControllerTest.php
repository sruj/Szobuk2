<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ZarzadcaControllerTest extends WebTestCase
{

    public function testRegularUsersCannotAccessToTheBackend()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'chinczyk',
            'PHP_AUTH_PW' => 'hinolp9',
        ]);

        $client->request('GET', '/zarzadca/');
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }

    public function testAdministratorUsersCanAccessToTheBackend()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);
        $client->request('GET', '/zarzadca/');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }


    public function testFilterStatus()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        $form = $crawler->selectButton('status[filtruj]')->form();
        $form['status[status]']->select(3); //wysłane
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "");

        $rowWyslane = $crawler->filterXPath('//td/div/select/option[@selected=\'selected\'][text()[contains(.,\'wyslane\')]]')->count();
        $rowsNum = $crawler->filterXPath('//tr/td[1]')->count();
        $this->assertTrue($rowWyslane==$rowsNum, "Filtrowanie złe. Wszystkie zamówienia powinny mieć status 'wysłane' ");

        $form = $crawler->selectButton('status[filtruj]')->form();
        $form['status[status]']->select(1); //nie zaplacone
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "");

        $rowWyslane = $crawler->filterXPath('//td/div/select/option[@selected=\'selected\'][text()[contains(.,\'nie zaplacone\')]]')->count();
        $rowsNum = $crawler->filterXPath('//tr/td[1]')->count();
        $this->assertTrue($rowWyslane==$rowsNum, "Filtrowanie złe. Wszystkie zamówienia powinny mieć status 'nie zaplacone' ");

        $form = $crawler->selectButton('status[filtruj]')->form();
        $form['status[status]']->select(2); //zaplacone
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "");

        $rowWyslane = $crawler->filterXPath('//td/div/select/option[@selected=\'selected\'][text()[contains(.,\'zaplacone\')]]')->count();
        $rowsNum = $crawler->filterXPath('//tr/td[1]')->count();
        $this->assertTrue($rowWyslane==$rowsNum, "Filtrowanie złe. Wszystkie zamówienia powinny mieć status 'zaplacone' ");

    }


    public function testFilterData()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        $form = $crawler->selectButton('data[filtruj]')->form();
        $form['data[do][year]']->select(2014);
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "");

    }


    public function testFilterKlient()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        $form = $crawler->selectButton('idklient[filtruj]')->form();
        $form['idklient[idklient]']->select(2); //wysłane
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "");

    }


    public function testPanel_0()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);
        $crawler = $client->request('GET', '/zarzadca/panel');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
    }

    public function testPanel_1()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);
        $crawler = $client->request('GET', '/zarzadca/panel/DESC/datazlozenia');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/DESC/datazlozenia");
    }

    public function testPanel_2()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel/ASC/idstatus');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/ASC/idstatus");
    }

    public function testPanel_3()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel/ASC/idklient');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/ASC/idklient");
    }

    public function testPanel_4()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel/null/idstatus');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/null/idstatus");
    }

    public function testPanel_5()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel/ASC/idklient');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/ASC/idklient");
    }

    public function testPanel_6()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        $crawler = $client->request('GET', '/zarzadca/panel/null/idklient');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/ASC/datazlozenia");
    }

    public function testPanel_7()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);
        $crawler = $client->request('GET', '/zarzadca/panel/ASC/datazlozenia');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
    }



    public function testCompleteScenarioManuAdmin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);
        $crawler = $client->request('GET', '/zarzadca/');
        $this->assertGreaterThan(0, $crawler->filter('h3:contains("Menu")')->count(),
            'Strona /zarzadca/ nie zawiera h3:contains("Menu")');

        //czy działa link 'zamówienia'
        $link = $crawler->filterXPath('//*[text()[contains(.,\'zamówienia\')]]')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
        $this->assertGreaterThan(4, $crawler->filterXPath('//thead/tr/th')->count(), 'Missing elements //thead/tr/th - means there is no table head ' );
        $this->assertEquals(3, $crawler->filter('button:contains("Filtruj")')->count(),
            'Missing elements button:contains("Filtruj") - means there are no 3 filter buttons');
        $crawler = $client->back();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        //czy działa link 'kategorie - edycja'
        $link = $crawler->filterXPath('//*[text()[contains(.,\'kategorie - edycja\')]]')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
        $this->assertGreaterThan(20, $crawler->filterXPath('//li/a[text()[contains(.,\'edit\')]]')->count(), 'Missing elements //li/a[text()[contains(.,edit)]]- means there is no edit elements' );
        $this->assertEquals(1, $crawler->filter('a:contains("Dodaj Nową Kategorię")')->count(),
            'Missing elements a:contains("Dodaj Nową Kategorię") - means there are no button "Dodaj Nową Kategorię"');
        $crawler = $client->back();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        //czy działa link 'dodaj kategorię'
        $link = $crawler->filterXPath('//*[text()[contains(.,\'dodaj kategorię\')]]')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
        $this->assertGreaterThan(0, $crawler->filterXPath('//h3[text()[contains(.,\'dodaj kategorię\')]]')->count(), 'Missing elements //h3[text()[contains(.,\'dodaj kategorię\')]]' );
        $this->assertEquals(1, $crawler->filter('button:contains("Dodaj")')->count(),
            'Missing elements button:contains("Dodaj") ');
        $crawler = $client->back();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        //czy działa link 'książki - edycja'
        $link = $crawler->filterXPath('//*[text()[contains(.,\'książki - edycja\')]]')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
        $this->assertGreaterThan(4, $crawler->filterXPath('//thead/tr/th')->count(), 'Missing elements //thead/tr/th - means there is no table head ' );
        $this->assertEquals(1, $crawler->filter('a:contains("Dodaj nową książkę")')->count(),
            'Missing elements a:contains("Dodaj nową książkę") - means there are no button');
        $this->assertEquals(1, $crawler->filter('button:contains("Zapisz zmiany")')->count(),
            'Missing elements button:contains("Zapisz zmiany") - means there are no button');
        $crawler = $client->back();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");

        //czy działa link 'dodaj książkę'
        $link = $crawler->filterXPath('//*[text()[contains(.,\'dodaj książkę\')]]')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
        $this->assertEquals(1, $crawler->filter('button:contains("Dodaj")')->count(),
            'Missing elements button:contains("Dodaj") - means there are no button');
        $this->assertEquals(1, $crawler->filter('h3:contains("Dodaj Książkę")')->count(),
            'Missing elements h3:contains("Dodaj Książkę")');
        $crawler = $client->back();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /zarzadca/panel/");
    }

}

