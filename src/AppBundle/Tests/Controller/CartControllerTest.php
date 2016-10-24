<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartControllerTest extends WebTestCase
{
    public function testAddtocart()
    {
        $client = static::createClient();

        $client->request('GET', '/addtocart/978-0010465284');
        $this->assertTrue($client->getResponse()->isRedirect('/cartmenu'));

        $client->request('GET', '/addtocart/978-0040892976');

        //testuję od razu CartController:cartcontentAction(), czyli liczba produktów w koszyku.
        $crawler = $client->request('GET', '/cartmenu');
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("2")')->count() > 0);

        //testuję od razu usuwanie jednego produktu CartController:cartmenuAction() gdy klikniętu "usuń" przy produkcie.
        $crawler = $client->request('GET', '/cartmenu/978-0040892976');
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("1")')->count() > 0);
        $this->assertTrue($crawler->filter('td > a:contains("978-0010465284")')->count() > 0);
        $this->assertTrue($crawler->filter('td > a:contains("978-0040892976")')->count() == 0);

        //testuję od razu CartController:cartclearAction()
        $crawler = $client->request('GET', '/cartclear');
        $this->assertTrue($crawler->filter('h3.szaryKlocek:contains("Koszyk pusty")')->count() > 0);
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("0")')->count() > 0);


        //tu chciałem sprawdzić klikanie, ale przenioslem sie do Selenium.
//        $link = $crawler
//            ->filter('a:contains("Greet")') // find all links with the text "Greet"
//            ->eq(1) // select the second link in the list
//            ->link()
//        ;
//        $crawler = $client->click($link);

    }

    public function testAutoryzacja()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/autoryzacja');

        $this->assertTrue($crawler->filter('h3:contains("Wybierz sposób autoryzacji")')->count() > 0);


    }

    public function testCartmenu()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cartmenu');

        //testuję gdy wchodzę do kosza gdy kosz pusty
        $this->assertTrue($crawler->filter('html:contains("Koszyk pusty.")')->count() > 0);
        //refaktor: wyświetla stronę w wersji deweloperskiej, stąd nie ma ikony koszyka ani szarego boxu z komunikatem, lecz surowy błąd. Poprawić by wyświetlał w wersji produkcyjnej i odkomentować dwie poniższe linie.
//        $this->assertTrue($crawler->filter('h3.szaryKlocek:contains("Błąd. Koszyk pusty.")')->count() > 0);
//        $this->assertTrue($crawler->filter('div.quantityKosz:contains("0")')->count() > 0);






    }

}
