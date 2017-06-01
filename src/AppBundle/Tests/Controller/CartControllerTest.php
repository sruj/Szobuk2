<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CartControllerTest extends WebTestCase
{
    public function testBuyProductByRegisteredCustomer()
    {
        $client = static::createClient();

        //dodaję produkty, sprawdzam czy przekierował do cart_menu
        $client->request('GET', '/add-to-cart/978-0010465284');
        $this->assertTrue($client->getResponse()->isRedirect('/cart'));
        $client->request('GET', '/add-to-cart/978-0040892976');
        $crawler = $client->followRedirect();

        //testuję od razu CartController:cartcontentAction(), czyli liczba produktów w koszyku.
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("2")')->count() > 0);

        //testuję od razu usuwanie jednego produktu CartController:cartMenuAction() gdy kliknięto "usuń" przy produkcie.
        $crawler = $client->request('GET', '/cart/978-0040892976');
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("1")')->count() > 0);
        $this->assertTrue($crawler->filter('td > a:contains("978-0010465284")')->count() > 0);
        $this->assertTrue($crawler->filter('td > a:contains("978-0040892976")')->count() == 0);

        //wybiera "zamawiam" i zostaję przekierowany do wyboru autoryzacji.
        $link = $crawler->filter('a:contains("zamawiam")')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("Wybierz sposób autoryzacji")')->count() > 0);

        //wybieram "zaloguj"
        $link = $crawler->filter('a:contains("zaloguj")')->link();
        $client->click($link);
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("Login")')->count() > 0);

        //Podaje dane logowania i zosaję przekierowany do formularza dostawy.
        $form = $crawler->selectButton('_submit')->form();
        $client->submit($form,[
            '_username'=>'chinczyk',
            '_password'=>'hinolp9',
        ]);
        $client->followRedirect();
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("Dostawa - formularz")')->count() > 0);

        //wypełniam dane, zatwierdzam i dostaję przekierowany do podsumowania zamówienia.
        $form = $crawler->selectButton('dostawa[zapisz]')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("zamówione produkty:")')->count() > 0);

        //Testuję od razu CartController:cartclearAction()
        $crawler = $client->request('GET', '/cart-clear');
        $this->assertTrue($crawler->filter('h3.szaryKlocek:contains("Koszyk pusty")')->count() > 0);
        $this->assertTrue($crawler->filter('div.quantityKosz:contains("0")')->count() > 0);
    }
    
    public function testBuyProductByUnregisteredCustomer()
    {
        $client = static::createClient();

        $client->request('GET', '/add-to-cart/978-0010465284');
        $crawler = $client->followRedirect();

        //wybiera "zamawiam" i zostaję przekierowany do wyboru autoryzacji.
        $link = $crawler->filter('a:contains("zamawiam")')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("Wybierz sposób autoryzacji")')->count() > 0);

        //wybieram "kup bez rejestracji"
        $link = $crawler->filter('a:contains("kup bez rejestracji")')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("Dostawa - formularz")')->count() > 0);

        //wypełniam dane, zatwierdzam i dostaję przekierowany do podsumowania zamówienia.
        $form = $crawler->selectButton('dostawa[zapisz]')->form();
        $client->submit($form,[
            'dostawa[name]'=>'paweł',
            'dostawa[surname]'=>'chryplewicz',
            'dostawa[email]'=>'chryplewiczpawel@wp.pl',
            'dostawa[street]'=>'ddd',
            'dostawa[houseNumber]'=>'22',
            'dostawa[apartmentNumber]'=>'2',
            'dostawa[postalCode]'=>'59-300',
            'dostawa[city]'=>'Lubin',
            'dostawa[nip]'=>'1234567890',
            'dostawa[phoneNumber]'=>'78687677',
        ]);
        $crawler = $client->followRedirect();
        $this->assertTrue($crawler->filter('html:contains("zamówione produkty:")')->count() > 0);
    }

    public function testAuthorization()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/authorization');

        $this->assertTrue($crawler->filter('h3:contains("Wybierz sposób autoryzacji")')->count() > 0);
    }

    public function testCartMenu()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cart');

        //testuję gdy wchodzę do kosza gdy kosz pusty
        $this->assertTrue($crawler->filter('html:contains("Koszyk pusty.")')->count() > 0);
        //refaktor: wyświetla stronę w wersji deweloperskiej, stąd nie ma ikony koszyka ani szarego boxu z komunikatem, lecz surowy błąd. Poprawić by wyświetlał w wersji produkcyjnej i odkomentować dwie poniższe linie.
//        $this->assertTrue($crawler->filter('h3.szaryKlocek:contains("Błąd. Koszyk pusty.")')->count() > 0);
//        $this->assertTrue($crawler->filter('div.quantityKosz:contains("0")')->count() > 0);
    }

//        $client = static::createClient([], [
//            'PHP_AUTH_USER' => 'chinczyk',
//            'PHP_AUTH_PW' => 'hinolp9',
//        ]);
//        $content = $client->getResponse()->getContent();
//        $f=0;



//    public function testBuyProductByRegisteredCustomer()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/ksiazka/');
//
//        $link = $crawler
//            ->filter('a:contains("Accountant")')
//            ->link()
//        ;
//
//        $crawler = $client->click($link);
//        $this->assertTrue($crawler->filter('html:contains("Mississippi")')->count() > 0);
//    }

}
