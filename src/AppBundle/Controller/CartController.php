<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DostawaType;
use AppBundle\Entity\Klient;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\Ksiazka;


//refaktor: zmienić nazwy metod PL-EN
class CartController extends Controller
{
    
    /**
     * Dodaj książkę do koszyka.
     *
     * (zmienna sesji 'cart' przechowuje tablicę produktów $isbn=>$ilość)
     *
     * @Route("/addtocart/{isbn}", name="addtocart")
     */
    public function addtocartAction(Request $request, $isbn)
    {
        $entity = $this->getDoctrine()->getRepository('AppBundle:Ksiazka')->find($isbn);

        if (!$entity) { throw new \Exception('Książka z numerem isbn: '.$isbn.' nie istnieje w bazie'); }

        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $cart = $this->getCartFromSessionOrReturnNullIfNotExist($session);

        $cart = $app_cart->addProductToCart($isbn, $cart);
        $session->set('cart', $cart);

        return $this->redirect($this->generateUrl('cartmenu'));
    }


    /**
     * Ilość produktów w koszyku.
     *
     * Akcja używana przez layout jako {% render ... %}
     * Wyswietlane tam gdzie {% extends '::layout.html.twig' %}
     */
    public function cartcontentAction(Request $request)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $cart = $this->getCartFromSessionOrReturnNullIfNotExist($session);
        $cartquantity = $app_cart->getNumerOfProductsInCart($cart);

        return $this->render('AppBundle:Cart:cartcontent.html.twig', ['cartquantity' => $cartquantity]);
    }
    
    
    /**
     * Czyszczenie koszyka.
     * todo: czyści całą sesję, nie wiem czy to najlepszy pomysł. (może ograniczyć się do usunięcia 'cart' i 'sum')
     *
     * @Route("/cartclear", name="cartclear")
     */
    public function cartclearAction(Request $request)
    {
        $request->getSession()->invalidate();

        return $this->render('AppBundle:Cart:cartclear.html.twig', []);
    }
    

    /**
     * Wybór autoryzacji
     * (zaloguj, zarejestruj, kup bez rejestracji)
     * 
     * @Route("/autoryzacja", name="autoryzacja")
     */
    public function autoryzacjaAction()
    {
        return $this->render('AppBundle:Cart:autoryzacja.html.twig', []);
    }



    /**
     * - Jeśli nie jestem zalogowany i będąc w cartmenu klikam "zamawiam" to jestem przekierowany do /autoryzacja a
     *  po wybraniu "zaloguj" lub "zarejestruj" zostaję przeniesiony TU.
     * - TU ustawiam nową zmienną sesji 'proces_zamowienia', która będzie potrzebna w dalszym etapie by przekierować
     *  w odpowiedni route po zalogowaniu.
     *
     * @Route("/przejsciowka/{autoryzacja}", defaults={"autoryzacja" = "zaloguj"}, name="przejsciowka")
     */
    public function przejsciowkaAction(Request $request, $autoryzacja)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $session->set('proces_zamowienia', 'tak'); // zmianna sesji by w dalszym etapie przekierować w odpowiedni route
        $route = $app_cart->prepareRoute($autoryzacja); // wybiera nazwę route zaloguj lub rejestruj

        return $this->redirectToRoute($route);
    }



    /**
     * Koszyk.
     * Tu trafiam po dodaniu produktu do koszyka lub po kliknięciu w koszyk.
     * Tu również kierowane jest żądanie gdy wybieram "usuń" chcąc usunąć książkę z koszyka.
     *
     * @Route("/cartmenu/{deleteisbn}", defaults={"deleteisbn" = false}, name="cartmenu")
     */    
    public function cartmenuAction(Request $request, $deleteisbn)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        
        if(!$session->has('cart')){
            throw new \Exception('Koszyk pusty.');
        }

        if($deleteisbn) { 
            $updatedCart = $app_cart->removeProductFromCart($deleteisbn,$session->get('cart'));
            $session->set('cart', $updatedCart);
        }

        $sum = $app_cart->getSumOfAllProductsInCart($session->get('cart'));
        $booksInCartDetails = $app_cart->getAllBooksFromCartDetails($session->get('cart'));

        $session->set('sum',$sum);
        
        return $this->render('AppBundle:Cart:cartmenu.html.twig',[
            'ksiazki' => $booksInCartDetails,
            'suma'=> $sum
        ]);
    }
    


    /**
     * zmiana ilości w cartmenu prowadzi przez skrypt JavaScript tutaj.
     *
     * Na stronie dane zmieniają się automatycznie dzięki skryptowi JS,
     * ale drugim zadaniem skryptu jest te dane przesłać tutaj (bym i ja wiedział a nie tylko przeglądarka i klikający użytkownik)
     * Więc nowe dane trafiają tu, i na ich podstawie aktualizuję zmienne sesji.
     * 
     * @Route("/zmianaQuantity", name="zmianaQuantity", options={"expose"=true})
     */
    public function zmianaQuantityAction(Request $request)
    {
        $cart = $request->get('data');                  //todo: jaka data? zobacz co to za data i zmień nazwę zmiennej.  //Odpowiedź: z JS tablica z zawartością koszyka
        $app_cart = $this->get('app.cart');  
        $session = $request->getSession();
        
        $session->set('cart',$cart );
        $session->set('sum',$app_cart->getSumOfAllProductsInCart($cart));

        return []; 
    }





    /**
     * Formularz danych adresowych klienta.
     *
     * - jeśli poprawnie wypełniono formularz, zamówienie i dane klienta zapisane w bazie.
     * - wystrzeliwany event a listenery robią robotę.
     * @Route("/zamawiam", name="zamawiam")
     */
    public function zamawiamAction(Request $request)
    {
        $session = $this->get('session');
        if(!$session->has('cart')){throw new \Exception('Koszyk pusty.');}

        $klient= $this->getDoctrine()
            ->getRepository('AppBundle:Klient')
            ->findOneBy(['idlogowanie' => $this->getUser() ? $this->getUser()->getId() : false]); // zalogowany wypełniał kiedyś formularz
        if (!$klient){$klient = new Klient();} // jeśli zalogowany nigdy nie wypełniał formularza dostawy lub jeśli niezalogowany

        $form= $this->createForm(DostawaType::class, $klient, array(
        'attr' => array('class' => 'form_dostawa')));

        $formHandler = $this->get('app.form_handler.zamowienie');
        if($formHandler->handle($form, $request)){               //wystrzeliwany event todo: może lepiej jak event bęzie wystrzeliwany w kontrolerze
            return $this->redirectToRoute('potwierdzenie');      //todo: poza tym listener używa sesji.
        };

        return $this->render('AppBundle:Cart:zamawiam.html.twig',[
            'form' => $form->createView()
        ]);
    }
    

    
    /**
     * Potwierdzenie.
     * 
     * @Route("/potwierdzenie", name="potwierdzenie")
     */
    public function potwierdzenieAction(Request $request)
    {
        $idzamowienie = $request->getSession()->getFlashBag()->get('idzamowienie');
        if (!$idzamowienie) {
            throw new \Exception('To jest strona potwierdzająca zamówienie. Aby złożyć zamówienie dodaj produkt do koszyka i tak dalej...');
        }

        $zamowienie = $this->getDoctrine()
            ->getRepository('AppBundle:Zamowienie')
            ->find($idzamowienie[0]);
        $produkty = $zamowienie->getZamowienieProdukty();
        $suma=$request->getSession()->get('sum');
        
        return $this->render('AppBundle:Cart:potwierdzenie.html.twig',[
            'zamowienie'=>$zamowienie, 'produkty'=>$produkty,
            'suma'=>$suma
        ]);
    }

    /**
     * @param $session
     * @return null
     */
    private function getCartFromSessionOrReturnNullIfNotExist($session)
    {
        $cart = null;

        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }
        return $cart;
    }

}
