<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DostawaType;
use AppBundle\Entity\Klient;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\ZamowienieProdukt;
use AppBundle\Entity\Status;
use AppBundle\Entity\Ksiazka;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartController extends Controller
{
    
    
    /**
     * @Route("/addtocart/{isbn}", name="addtocart")
     */
    public function addtocartAction(Request $request, $isbn)
    {
        $entity = $this->getDoctrine()->getRepository('AppBundle:Ksiazka')->find($isbn);

        if (!$entity) { throw new \Exception('Książka z numerem isbn: '.$isbn.' nie istnieje w bazie'); }
        
        $session = $request->getSession();
        
        if($session->has('cart'))//jeśli zmienna sesji cart juz jest to:
        { 
            $cart = $session->get('cart');
            if(!array_key_exists($isbn,$cart))//jeśli isbn nie jest w koszu
            {
                $cart[$isbn]=1; // = 1
            }
            else
            {
              $cart[$isbn]++; //to zwiększ wartość ++
            }
        }
        else
        {
            $cart[$isbn]=1;
        }
            $session->set('cart',$cart );
            
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
        $session = $request->getSession();

        if($session->has('cart'))//jeśli zmienna sesji cart juz jest to:
        {         
            $cart = $session->get('cart');
            $cartquantity = array_sum($cart)  ;        
        }
        else
        {
            $cartquantity = 0;
        }

        return $this->render('AppBundle:Cart:cartcontent.html.twig', ['cartquantity' => $cartquantity]);
    }
    
    
    
    
    /**
     * Czyszczenie koszyka.
     * 
     * @Route("/cartclear", name="cartclear")
     */
    public function cartclearAction(Request $request)
    {
        $session = $request->getSession();
        $session->invalidate();

        return $this->render('AppBundle:Cart:cartclear.html.twig', []);
    }
    
    
    
    
    /**
     * Zapłać. Formularz
     * 
     * @Route("/autoryzacja", name="autoryzacja")
     */
    public function autoryzacjaAction(Request $request)
    {
        return $this->render('AppBundle:Cart:autoryzacja.html.twig', []);
    }
    
    
    
    
    /**
     * Koszyk.
     * 
     * @Route("/cartmenu/{deleteisbn}", name="cartmenu")
     */    
    public function cartmenuAction(Request $request, $deleteisbn='')
    {
        
        $cart_obiekt = $this->get('my_cart'); // serwis
        
        if(!$cart_obiekt->session->has('cart')){
            throw new \Exception('Koszyk pusty.');
        }
        
        $cart_obiekt->deleteKsiazkaKoszyk($deleteisbn); // gdy kliknięto 'usuń' przy książce w cartmenu
        $cart_obiekt->przygotujZawartoscKoszyka(); // utworzenie tablicy 'ksiazki' z danymi o każdej z nich i ilością w koszyku

        // utworzenie zmiennej sesji 'suma' czyli kwoty do zapłaty (przyda się w podsumowaniu zakupu)
        $session = $request->getSession();
        $session->set('suma',$cart_obiekt->suma );

        return $this->render('AppBundle:Cart:cartmenu.html.twig',[
            'ksiazki' => $cart_obiekt->ksiazki,
            'suma'=>$cart_obiekt->suma
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
        $data = $request->request->get('data');
        $session = $request->getSession();

        $session->set('cart',$data );

        $cart_obiekt = $this->get('my_cart'); // serwis
        $cart_obiekt->przygotujZawartoscKoszyka();
        $session->set('suma',$cart_obiekt->suma );
        
        return []; 
    }
    
    /**
     * 
     * @Route("/przejsciowka/{autoryzacja}", name="przejsciowka")
     * 
     */
    public function przejsciowkaAction(Request $request,$autoryzacja)
    {
        $session = $request->getSession();
        $session->set('proces_zamowienia', 'tak');    
        
        switch ($autoryzacja){
            case 'zaloguj':
                return $this->redirectToRoute('fos_user_security_login');
                break;
            case 'zarejestruj':
                return $this->redirectToRoute('fos_user_registration_register');
                break;
        }
        
        return [];
    }

    
    
    /**
     * Formularz danych adresowych klienta.
     * 
     * @Route("/zamawiam", name="zamawiam")
     */
    public function zamawiamAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $logged = $this->get('security.authorization_checker')
                ->isGranted('IS_AUTHENTICATED_FULLY');
        
        if(!$session->has('cart')){
            throw new \Exception('Koszyk pusty.');
        }
         
        if ($logged) //jeśli zalogowany użytkownik
        {    
            //if (wypełniał wcześniej formularz){
            $idlogowanie = $this->getUser()->getId();
            $klient= $this->getDoctrine()
                ->getRepository('AppBundle:Klient')
                ->findOneBy(array('idlogowanie' => $idlogowanie));
            // jeśli zalogowany nigdy nie wypełniał formularza dostawy
                if (! is_object($klient)){$klient = new Klient();}
        }
        else
        {
            $klient = new Klient();
        }
        $form= $this->createForm(DostawaType::class, $klient, array(
        'attr' => array('class' => 'form_dostawa')));

        $form->handleRequest($request);

        if ($form->isValid())
        {
            //linijka dla zalogowanego użytkownika
            if ($logged){
            $klient->setIdlogowanie($this->getUser());
            }
            //wypełnienie tabeli Zamowienie
            $zamowienie = new Zamowienie();
            $zamowienie->setIdklient($klient);
            $status = $this->getDoctrine()
                    ->getRepository('AppBundle:Status')
                    ->find('1');
            $zamowienie->setIdstatus($status);
            $zamowienie->setDatazlozeniacurrent();
            //wypełnienie tabeli Zamowienie_Produkt
            $cart = $session->get('cart');
            foreach ($cart as $isbn => $quantity)
            {   
                $ksiazka = $this->getDoctrine()
                    ->getRepository('AppBundle:Ksiazka')
                    ->find($isbn);
                $isbn=$ksiazka->getIsbn();        
                $tytul=$ksiazka->getTytul();        
                $autor=$ksiazka->getAutor();
                $cena=$ksiazka->getCena();        
                $rokwydania=$ksiazka->getRokwydania();        
                $ilosc=$quantity;        
                $zamowienieProdukt = new ZamowienieProdukt();
                $zamowienieProdukt->setIdzamowienie($zamowienie); 
                $zamowienieProdukt->setIsbn($ksiazka);
                $zamowienieProdukt->setTytul($tytul);
                $zamowienieProdukt->setAutor($autor);
                $zamowienieProdukt->setCenaproduktu($cena);
                $zamowienieProdukt->setRokwydania($rokwydania);
                $zamowienieProdukt->setIlosc($ilosc);
                $em->persist($zamowienieProdukt);
            }  

            $em->persist($klient);
            $em->persist($zamowienie);
            $em->flush();    

            $idzamowienia=$zamowienie->getIdzamowienie();
            $request->getSession()->getFlashBag()->add(
                'idzamowienie',
                $idzamowienia);
            return $this->redirect($this->generateUrl('potwierdzenie')
                    );
        }


        return $this->render('AppBundle:Cart:zamawiam.html.twig',[
            'form' => $form->createView()
        ]);

    }
    
    
    
    
    /**
     * Potwierdzenie.
     * 
     * @Route("/potwierdzenie", name="potwierdzenie")
     * @Template()
     */
    public function potwierdzenieAction(Request $request)
    {
        $idzamowienie=$request->getSession()->getFlashBag()->get('idzamowienie');
        
        if (!$idzamowienie) {
            throw new \Exception('To jest strona potwierdzająca zamówienie. Aby złożyć zamówienie dodaj produkt do koszyka i tak dalej...');
        }
        
        foreach($idzamowienie as $id)
        {
        $zamowienie= $this->getDoctrine()
                        ->getRepository('AppBundle:Zamowienie')
                        ->find($id);

        $produkty= $this->getDoctrine()
                        ->getRepository('AppBundle:ZamowienieProdukt')
                        ->findBy(array('idzamowienie'=>$id));
        }
        $suma=$request->getSession()->get('suma');

        //mail do klienta ze szczegółami zamówienia
        $Klient=$this->getDoctrine()
                            ->getRepository('AppBundle:Klient')
                            ->find($zamowienie->getIdklient());
        $mailKlient=$Klient->getEmail();
        $messageToKlient = \Swift_Message::newInstance()
            ->setSubject('Księgarnia Szobuk - potwierdzenie zamówienia')
            ->setFrom('send@example.com')
            ->setTo($mailKlient)
            ->setBody(
                $this->renderView(
                    'AppBundle:Cart:potwierdzenieMail.html.twig',
                    array('zamowienie'=>$zamowienie, 'produkty'=>$produkty,
                'suma'=>$suma)
                ),
                'text/html'
            )
                        ->addPart(
                $this->renderView(
                    'AppBundle:Cart:potwierdzenieMail.html.twig',
                    array('zamowienie'=>$zamowienie, 'produkty'=>$produkty,
                'suma'=>$suma)
                ),
                'text/plain'
            );

        //mail do zarządcy informujący o nowym zamówieniu
            $mailZarzadca='chryplewiczpawel@gmail.com';
            $messageToZarzadca = \Swift_Message::newInstance()
            ->setSubject('Księgarnia Szobuk - Złożono nowe zamówienie')
            ->setFrom('send@example.com')
            ->setTo($mailZarzadca)
            ->setBody(
                $this->renderView(
                    'AppBundle:Cart:potwierdzenieMailZarzadca.html.twig',
                    array('zamowienie'=>$zamowienie, 'produkty'=>$produkty,
                'suma'=>$suma)
                ),
                'text/html'
            )
            ->addPart('Złożono nowe zamówienie',
                'text/plain'
            )
            ;

        $this->get('mailer')->send($messageToKlient);
        $this->get('mailer')->send($messageToZarzadca);

        return $this->render('AppBundle:Cart:potwierdzenie.html.twig',[
            'zamowienie'=>$zamowienie, 'produkty'=>$produkty,
            'suma'=>$suma
        ]);
    }
}