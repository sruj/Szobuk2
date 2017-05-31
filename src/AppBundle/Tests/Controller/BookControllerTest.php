<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\BookList;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Tests\Utils\ColumnSortChecker;

class BookControllerTest extends WebTestCase
{
    private $columnSortChecker;

    /**
     * KsiazkaControllerTest constructor.
     */
    public function __construct()
    {
        $this->columnSortChecker = new \AppBundle\Tests\ColumnSortChecker();
    }

    public function testSortowanie()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/book/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /book/");
        $isSort = $this->columnSortChecker->isAlphabetic('//tbody/tr[', ']/td[1]/a', $crawler);
        $this->assertTrue($isSort, 'Kolumna tytuł nieposortowana');

        //-Poniżej testuję sortowanie wg kolumny author
        //-Mógłbym testować i wszystkie kolumny ale nie da rady przetestować sorotwania wg kolumn bo knp_pagination jakoś po swojemu manipuluje obiekt
        // Request z parametrami url, i testy Symfony tego nie widzą.
        //-Zatem poniższy kod mimo że dobry to nie nadaje się - więc zakomentowany
        //https://github.com/KnpLabs/KnpPaginatorBundle/issues/398
        //http://forum.php.pl/index.php?showtopic=252655
        //http://stackoverflow.com/questions/40261754/how-to-functional-test-sites-with-knp-pagination-sortable
//        $link = $crawler->filterXPath('//th[2]/a[@class=\'sortable\']')->link(); //  to samo co: $crawler = $client->request('GET', '/book/?sort=a.author&direction=asc&page=1');
//        $crawler = $client->click($link);
//        $isSort = $this->columnSortChecker->isAlphabetic('//tbody/tr[', ']/td[2]/a', $crawler);
//        $this->assertGreaterThan(6, $crawler->filter('a:contains("Artur Rimbaud")')->count(), 'Kolumna author nieposortowana');
    }

    public function testIndex()
    {
        $client = static::createClient();

        //testuję czy strona istnieje i czy wyświetla wiersze tabeli.
        $crawler = $client->request('GET', '/book/');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected HTTP status code for GET /book/");
        $this->assertEquals(BookList::NUM_ITEMS, $crawler->filterXPath('//tbody/tr')->count(),
            'Za mało wyświetlonych ksiazek lub wcale.');

        //testuję paginację
        $link = $crawler->filterXPath('//span[@class=\'last\']/a')->link();
        $crawler = $client->click($link);
        $this->assertGreaterThan(0, $crawler->filterXPath('//tbody/tr')->count(),
            'Coś nie tak z paginacją. Ostatnia strona nie ma ani jednego wiersza.');

    }


    public function testCompleteScenario()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'wazny',
            'PHP_AUTH_PW' => 'wazny',
        ]);

        // Create a new entry in the database
        $crawler = $client->request('GET', '/book/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /book/");
        $crawler = $client->click($crawler->selectLink('Dodaj nową książkę')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Dodaj')->form(array(
            'appbundle_ksiazka[title]' => 'TytułTF',
            'appbundle_ksiazka[author]' => 'AutorTF',
            'appbundle_ksiazka[description]' => 'opisTF',
            'appbundle_ksiazka[isbn]' => '978-1-56619-909-4',
            'appbundle_ksiazka[price]' => '38.00',
            'appbundle_ksiazka[picture]' => 'book_nr_101.jpg',
            'appbundle_ksiazka[print]' => 'Brown',
            'appbundle_ksiazka[publishyear]' => '1984',
            'appbundle_ksiazka[idcategory]' => '3',
            'appbundle_ksiazka[quantity]' => '10',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertGreaterThan(0, $crawler->filter('td:contains("TytułTF")')->count(), 'Missing element td:contains("TytułTF")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edycja')->link());

        $form = $crawler->selectButton('Zaktualizuj')->form(array(
            'appbundle_ksiazka[title]' => 'Foo',
            'appbundle_ksiazka[author]' => 'Bar',
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Usuń')->form());
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code after removing entity");

    }
}