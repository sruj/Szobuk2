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

    public function testCompleteScenario()
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








//    /**
//     * @dataProvider getPublicUrls
//     */
//    public function testPublicUrls($url)
//    {
//        $client = self::createClient();
//        $client->request('GET', $url);
//        $this->assertTrue(
//            $client->getResponse()->isSuccessful(),
//            sprintf('The %s public URL loads correctly.', $url)
//        );
//    }
//    /**
//     * @dataProvider getSecureUrls
//     */
//    public function testSecureUrls($url)
//    {
//        $client = self::createClient();
//        $client->request('GET', $url);
//        $this->assertTrue($client->getResponse()->isRedirect());
//        $this->assertEquals(
//            'http://localhost/en/login',
//            $client->getResponse()->getTargetUrl(),
//            sprintf('The %s secure URL redirects to the login form.', $url)
//        );
//    }
//    public function getPublicUrls()
//    {
//        return array(
//            array('/'),
//            array('/popularne'),
//            array('/nowosci'),
//            array('/cartmenu'),
//            array('/kategoria'),
//            array('/login'),
////            array('/'),
//        );
//    }
//    public function getSecureUrls()
//    {
//        return array(
//            array('/zarzadca'),
//            array('/ksiazka/admin/create'),
//            // ...
//        );
//    }
//}
///addtocart/{isbn}
//  /cartclear
//  /autoryzacja
//  /cartmenu/{deleteisbn}
//  /zmianaQuantity
//  /przejsciowka/{autoryzacja}
//  /zamawiam
//  /potwierdzenie
//  /
///popularne
///nowosci
///kategoria/
///kategoria
///kategoria/admin/new
///kategoria/{id}
///kategoria/admin/{id}/edit
///kategoria/admin/{szatan}
///kategoria/admin/{id}/edits
///kategoria/admin/{id}/deletes
///historiaPanel
///ksiazka/
///ksiazka/admin/new
///ksiazka/admin/create
//  /ksiazka/show/{id}
//  /ksiazka/admin/edit/{id}
//  /ksiazka/admin/{id}/update
//  /ksiazka/admin/{id}/delete
//  /ksiazka/search/
///ksiazka/search/results/{word}
///ksiazka/{findby}-{what}/showBooksBy
///panel/szczegoly-zamowienia/{idzamowienie}/{userid}/
//  /panel/szczegoly-zamowienia/{idzamowienie}/
//  /zarzadca/
///zarzadca/panel/{findBy}-{Identifier}
//  /zarzadca/panel/{sortArr}/{orderBy}/{query}/{EntFldName}
//  /login
//  /login_check
//  /logout
//   /profile/
///profile/edit
//  /register/