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
use AppBundle\Utils\Cart;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartController extends Controller
{
    
    
    /**
     * @Route("/addtocart/{isbn}", name="addtocart")
     * @Template()
     */
    public function addtocartAction(Request $request, $isbn)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Ksiazka')->find($isbn);        
        if (!$entity) {
            throw new \Exception('Książka z numerem isbn: '.$isbn.' nie istnieje w bazie');
        }
        
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

        return $this->render('AppBundle:Cart:cartcontent.html.twig', 
            array('cartquantity' => $cartquantity));
    }
    
    
    
    
    /**
     * Czyszczenie koszyka.
     * 
     * @Route("/cartclear", name="cartclear")
     * @Template()
     */    
    public function cartclearAction(Request $request)
    {
        $session = $request->getSession();
        $session->invalidate();

        return $this->render('AppBundle:Cart:cartclear.html.twig', 
            array()
        );
    }
    
    
    
    
    /**
     * Zapłać. Formularz
     * 
     * @Route("/autoryzacja", name="autoryzacja")
     * @Template()
     */
    public function autoryzacjaAction(Request $request)
    {
        return array();    
    }
    
    
    
    
    /**
     * Koszyk.
     * 
     * @Route("/cartmenu/{deleteisbn}", name="cartmenu")
     * @Template()
     */    
    public function cartmenuAction(Request $request,$deleteisbn='')
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

        return $this->render('AppBundle:Cart:cartmenu.html.twig', 
            array('ksiazki' => $cart_obiekt->ksiazki, 
                'suma'=>$cart_obiekt->suma));

    }
    
//     * @Route( name="zmianaQuantity", options={"expose"=true})
    
    /**
     * zmiana ilości w cartmenu prowadzi przez skrypt JavaScript tutaj.
     * usunałem template bo zdaje sie ze niepotrzebne
     * 
     * @Route("/zmianaQuantity", name="zmianaQuantity", options={"expose"=true})
     * @Template()
     */
    public function zmianaQuantityAction(Request $request)
    {

        $data = $request->request->get('data');    
        
//        $cartZserwisu=$cart_obiekt->cart;
        $session = $request->getSession(); 
        
        $session->set('cart',$data );
        

        
        
        $cart_obiekt = $this->get('my_cart'); // serwis
        $cart_obiekt->przygotujZawartoscKoszyka(); 
        $session->set('suma',$cart_obiekt->suma );
        
        return array(); 
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
        
        return array(); 
    }

    
    
    /**
     * Formularz danych adresowych klienta.
     * 
     * @Route("/zamawiam", name="zamawiam")
     * @Template()
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
//                   echo '<pre>',print_r($idlogowanie),'</pre>'; 
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
        $form= $this->createForm(new DostawaType(), $klient, array(
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
//                        echo '<pre>',print_r($idzamowienia),'</pre>';  
            return $this->redirect($this->generateUrl('potwierdzenie')
//                return $this->redirect($this->generateUrl('test')
                    );
        }
        return array('form' => $form->createView());    
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
//          echo '<pre>',print_r($zamowienie->getIdzamowienie()),'</pre>';
          
    //mail do klienta ze szczegółami zamówienia   
    $Klient=new Klient();
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
        return array('zamowienie'=>$zamowienie, 'produkty'=>$produkty,
            'suma'=>$suma);
    }

    
    
    
    
    
    
    
    
    /**
     * test1.
     * 
     * @Route("/test1", name="test1")
     * @Template()
     */
    public function test1Action(Request $request)
    {
        $cart_obiekt = $this->get('my_cart'); // serwis
        
        if($cart_obiekt->session->has('cart'))
        { 
            $cart_obiekt->przygotujZawartoscKoszyka(); // utworzenie tablicy 'ksiazki' z danymi o każdej z nich i ilością w koszyku
            
            // utworzenie zmiennej sesji 'suma' czyli kwoty do zapłaty (przyda się w podsumowaniu zakupu)
            $session = $request->getSession();
            $session->set('suma',$cart_obiekt->suma );
            
            return $this->render('AppBundle:Cart:test1.html.twig', 
                array('ksiazki' => $cart_obiekt->ksiazki, 
                    'suma'=>$cart_obiekt->suma));
        }
         else 
        {
            return $this->render('AppBundle:Cart:cartmenu.html.twig', 
                array('pusty'=>'Kosz pusty!'));
        }
 
        
        
               return array();          
    }
    
    
    /**
     * test.
     * 
     * @Route("/test", name="test", options={"expose"=true})
     * @Template()
     */
    public function testAction(Request $request)
    {

     $data = $request->request->get('data');    
        echo '<pre>',print_r($data),'</pre>'; 
        
        
        
        $session = $request->getSession();    
        $session->set('data',$data );
//        return new Response("data set");
        return array(); 
    }


  /**
     * test.
     * 
     * @Route("/test2", name="test2")
     * @Template()
     */
    public function test2Action(Request $request)
    {

        $marek='marek';
        $session = $request->getSession();    
        $data = $session->get('data');
        
        echo '<pre>',print_r($data),'</pre>'; 
        echo '<pre>',var_dump($data),'</pre>'; 
        
        return array();
    }
    
    /**
     * test4.
     * 
     * @Route("/test4", name="test4")
     * @Template()
     */    
    public function test4Action(Request $request)
        {
        
        $session = $request->getSession();   
//        $session->clear();
        $lata = $session->get('data');
        $cart = $session->get('cart');
//        $cartZserwisu = $session->get('cartZserwisu');
        
        echo '<pre>',print_r($lata),'</pre>'; 
        echo '<pre>',var_dump($lata),'</pre>'; 
        echo '<pre>',print_r($cart),'</pre>'; 
        echo '<pre>',var_dump($cart),'</pre>'; 
//        echo '<pre>',print_r($cartZserwisu),'</pre>'; 
//        echo '<pre>',var_dump($cartZserwisu),'</pre>'; 
        
        return array();
        }    
    
    
    
  /**
     * test.
     * 
     * @Route("/test5", name="test5")
     * @Template()
     */
    public function test5Action(Request $request)
    {

        $session = $request->getSession();    
        $marek='marek';
        $session->set('marek',$marek);
        $data=$session->get('marek');
        echo '<pre>',print_r($data),'</pre>'; 
        echo '<pre>',var_dump($data),'</pre>'; 
        
        return array();
    }
  /**
     * test.
     * 
     * @Route("/test6", name="test6")
     * @Template()
     */
    public function test6Action(Request $request)
    {
$entity = new Ksiazka();

        $em = $this->getDoctrine()->getManager();
        $ksiazki = $em->getRepository('AppBundle:Ksiazka')->findAll();
        
//        $dobra=$ksiazki[0]->setTytul('dupa2');
//        
//                 $em->persist($dobra);
//                $em->flush();
                $plk = file('../data/professions.txt');
                
//                  echo '<pre>',print_r($plk),'</pre>';    
                $i=0;
                $j=100;
        foreach($ksiazki as $ksiazka){
            if($j===164){$j=100;};
            $isbn=$ksiazka->getIsbn();
            $y= $this->getDoctrine()
                    ->getRepository('AppBundle:Ksiazka')
                    ->findOneBy(array('isbn' => $isbn));
            $y->setTytul($plk[$i]);
            $y->setObrazek('book_nr_'.$j.'.jpg');
            
            $em->persist($y);
            $i=$i+3;
            $j++;
        }
         $em->flush();
        
                
        
//        $TablicaliczbyObrazki= zamieńkazdyWierszPiktekstowynaTablice(open($pathdopliku))        ;
//        $TablicaTytulow= zamieńkazdyWierszPiktekstowynaTablice(open($pathdopliku))        ;
//        
//        foreach ($ksiazka)      {
//            foreach($TablicaliczbyObrazki as $nazwaPliku){
//                $entity->setObrazek($nazwaPliku);
//                $entity->setTytul($tytul);                
//            }
//            
//            setObrazek()
//        }
                
//                  echo '<pre>',print_r($no),'</pre>';       
        
//        
//        $em->persist($entity);
//        $em->flush();


        return array();
    }
    
    

}
//        echo '<pre>',print_r($ksiazki),'</pre>';  