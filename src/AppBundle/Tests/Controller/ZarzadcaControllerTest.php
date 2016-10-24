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