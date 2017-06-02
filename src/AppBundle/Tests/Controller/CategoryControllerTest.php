<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testIndexAndShow()
    {
        //Testuję: strona z listą kategorii, kliknięcie listy wybranej kategorii, kliknięcie szczegółów wybranej książki.
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/category/');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(),"Unexpected HTTP status code for GET /category/");
        $this->assertGreaterThan(10, $crawler->filterXPath('//li/a/text()')->count(),
            'Za mało wyświetlonych kategorii lub wcale.');

        //wybiera "zamawiam" i zostaję przekierowany do wyboru autoryzacji.
        $link = $crawler->filter('a:contains("Horror")')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('div:contains("Kategoria: Horror")')->count() > 0,
            'Wybrana kategoria (Horror) nie zawiera książek');
        $this->assertGreaterThan(0, $crawler->filterXPath('//tbody/tr/td/a/text()')->count(),
            'Category (Horror) nie wyświetla żadnej książki w tabeli');

        //klikam w "więcej" informacji o książce i przenoszę się do podstrony o książce.
        $link = $crawler->filterXPath('//tbody/tr[1]/td[7]/a')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $response->getStatusCode(),
            "Unexpected HTTP status code for choosen book site");
        $this->assertTrue($crawler->filter('div.product-info')->count() > 0,
            'Strona książki nie wyświetla się.');
    }


    public function testCompleteScenarioAdmin()
    {
        //Scenariusz: Admin tworzy nową kategorię, edytuje, usuwa.
        
        // Create a new client to browse the application
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        // Create a new entry in the database
        $crawler = $client->request('GET', '/category/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /category/");
        $crawler = $client->click($crawler->selectLink('Dodaj Nową Kategorię')->link());
        $this->assertTrue($crawler->filter('h3:contains("dodaj kategorię")')->count() > 0,
            'Brak strony /category/admin/new');

        // Fill in the form and submit it
        $form = $crawler->selectButton('appbundle_category[submit]')->form(array(
            'appbundle_category[name]'  => 'Test',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect(); //todo: nie przechodzi tego , nie wiem dlaczego, w aplikacji nie ma problemu, musi tu byc jakiś błąd w nazwach po refaktoyzacji PL-EN

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('div:contains("Kategoria: Test")')->count(), 'Missing element a:contains("Category: Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edytuj Kategorię')->link());

        $form = $crawler->selectButton('Zaktualizuj')->form(array(
            'appbundle_category[name]'  => 'TestFunkcjonalny',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="TestFunkcjonalny"]')->count(), 'Missing element [value="TestFunkcjonalny"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Usuń')->form());
        $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/TestFunkcjonalny/', $client->getResponse()->getContent());
    }

    
}
