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

class CartController extends Controller
{
    
    /**
     * @Route("/addtocart/{isbn}", name="addtocart")
     */
    public function addtocartAction(Request $request, $isbn)
    {
        $entity = $this->getDoctrine()->getRepository('AppBundle:Ksiazka')->find($isbn);

        if (!$entity) { throw new \Exception('Książka z numerem isbn: '.$isbn.' nie istnieje w bazie'); }

        $serwis = $this->get('app.cart');
        $serwis->addProductToCart($isbn);
            
        return $this->redirect($this->generateUrl('cartmenu'));
    }



    /**
     * Ilość produktów w koszyku.
     *
     * Akcja używana przez layout jako {% render ... %}
     * Wyswietlane tam gdzie {% extends '::layout.html.twig' %}
     */
    public function cartcontentAction()
    {
        $serwis = $this->get('app.cart');
        $cartquantity = $serwis->getCartQuantity();

        return $this->render('AppBundle:Cart:cartcontent.html.twig', ['cartquantity' => $cartquantity]);
    }
    
    

    /**
     * Czyszczenie koszyka.
     * 
     * @Route("/cartclear", name="cartclear")
     */
    public function cartclearAction()
    {
        $serwis = $this->get('app.cart');
        $serwis->sessionInvalidate();        

        return $this->render('AppBundle:Cart:cartclear.html.twig', []);
    }
    
    

    /**
     * Zapłać. Formularz
     * 
     * @Route("/autoryzacja", name="autoryzacja")
     */
    public function autoryzacjaAction()
    {
        return $this->render('AppBundle:Cart:autoryzacja.html.twig', []);
    }


    
    /**
     * Koszyk.
     * Tu trafiam po dodaniu produktu do koszyka lub po kliknięciu w koszyk.
     * Tu również kierowane jest żądanie gdy wybieram "usuń" chcąc usunąć książkę z koszyka.
     * 
     * @Route("/cartmenu/{deleteisbn}", defaults={"deleteisbn" = false}, name="cartmenu")
     */    
    public function cartmenuAction($deleteisbn)
    {
        $serwis = $this->get('my_cart'); // serwis

        if(!$serwis->session->has('cart')){
            throw new \Exception('Koszyk pusty.');
        }

        if($deleteisbn) { // gdy kliknięto 'usuń' przy książce w cartmenu
            $serwis->usun_ksiazke_z_koszyka($deleteisbn);
        }

        $serwis->przygotuj_zawartosc_koszyka();

        return $this->render('AppBundle:Cart:cartmenu.html.twig',[
            'ksiazki' => $serwis->ksiazki,
            'suma'=>$serwis->suma
        ]);

    }
    


    /**
     * zmiana ilości w cartmenu prowadzi przez skrypt JavaScript tutaj.
     * usunałem template bo zdaje sie ze niepotrzebne
     * 
     * @Route("/zmianaQuantity", name="zmianaQuantity", options={"expose"=true})
     */
    public function zmianaQuantityAction(Request $request)
    {
        $serwis = $this->get('my_cart'); // serwis
        $serwis->zmien_quantity_produktow();

        return []; 
    }



    /**
     * - Jeśli nie jestem zalogowany i będąc w cartmenu klikam "zamawiam" to jestem przekierowany do /autoryzacja a
     *  po wybraniu "zaloguj" lub "zarejestruj" zostaję przeniesiony TU.
     * - TU ustawiam nową zmienną sesji 'proces_zamowienia', która będzie potrzebna w dalszym etapie by przekierować
     *  w odpowiedni route po zalogowaniu.
     *
     * @Route("/przejsciowka/{autoryzacja}", defaults={"autoryzacja" = "zaloguj"}, name="przejsciowka")
     */
    public function przejsciowkaAction($autoryzacja)
    {
        $serwis = $this->get('my_cart'); // serwis
        $serwis->session->set('proces_zamowienia', 'tak'); // zmianna sesji by w dalszym etapie przekierować w odpowiedni route
        $route = $serwis->wybierz_route($autoryzacja); // wybiera nazwę route zaloguj lub rejestruj

        return $this->redirectToRoute($route);
    }



    /**
     * Formularz danych adresowych klienta.
     * - jeśli poprawnie wypełniono formularz, zamówienie i dane klienta zapisane w bazie.
     * 
     * @Route("/zamawiam", name="zamawiam")
     */
    public function zamawiamAction(Request $request)
    {
        $session = $this->get('session');
        if(!$session->has('cart')){throw new \Exception('Koszyk pusty.');}

        $klient= $this->getDoctrine()
            ->getRepository('AppBundle:Klient')
            ->findOneBy(['idlogowanie' => $this->getUser()->getId()]); // zalogowany wypełniał kiedyś formularz
        if (!$klient){$klient = new Klient();} // jeśli zalogowany nigdy nie wypełniał formularza dostawy lub jeśli niezalogowany

        $form= $this->createForm(DostawaType::class, $klient, array(
        'attr' => array('class' => 'form_dostawa')));

        $formHandler = $this->get('app.form_handler.zamowienie');
        if($formHandler->handle($form, $request)){
            return $this->redirectToRoute('potwierdzenie');
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
        $idzamowienie=$request->getSession()->getFlashBag()->get('idzamowienie');
        if (!$idzamowienie) {
            throw new \Exception('To jest strona potwierdzająca zamówienie. Aby złożyć zamówienie dodaj produkt do koszyka i tak dalej...');
        }

        $zamowienie = $this->getDoctrine()
            ->getRepository('AppBundle:Zamowienie')
            ->find($idzamowienie[0]);
        $produkty = $zamowienie->getZamowienieProdukty();
        $suma=$request->getSession()->get('suma');
        
        return $this->render('AppBundle:Cart:potwierdzenie.html.twig',[
            'zamowienie'=>$zamowienie, 'produkty'=>$produkty,
            'suma'=>$suma
        ]);
    }

}