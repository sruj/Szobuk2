<?php

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager; 

/**
 * Description of cartClass
 *
 * @author chin
 */
class CartUtil {
    
    public $requestStack;
    public $request;
    public $ksiazki;
    public $cart;
    public $session;
    public $razem; // łączna kwota za jeden isbn. Kilka egzemplarzy tej samej książi
    public $suma; // łączna kwota za wszystkie książki.
    public $i;
    public $em;
    public $ksiazka;
    
    
    /**
     * __construct
     * ustawia zmienne 
     * 
     */  
    public function __construct(RequestStack $requestStack, EntityManager $em )
    {
        $this->requestStack = $requestStack;
        $this->request = $this->requestStack->getCurrentRequest();
        $this->session = $this->request->getSession();
        $this->cart = $this->session->get('cart');
        $this->razem= 0;
        $this->suma= 0 ;
        $this->i=0;
        $this->em= $em;
        
    }
           
    
     /**
     * @param $isbn
     * @return $ksiazka 
     * 
     * zwraca- repository z doctrine ksiażki 
     * 
     */          
    public function getKsiazka($isbn)
    {
//        var_dump($this->em);
        $ksiazkaRep=$this->em->getRepository('AppBundle:Ksiazka')
        ->find($isbn);

        return $ksiazkaRep;
    }
       
    
    /**
     * @param $isbn
     * @return nic
     * 
     * aktualizuje quantity 
     * 
     */      
    public function quantityUpdate($isbn)
    {        
        $this->ksiazki[$this->i]['quantity'] = $this->request->get($isbn);    
        $this->cart[$isbn] = $this->request->get($isbn);
        $this->request->getSession()->set('cart',$this->cart );
    }
           
            
    /**
     * @param $ksiazka
     * @return $ksiazki 
     * 
     * zwraca- tablicę dwuwymiarową, numeryczno asocjacyjna 
     * 
     */     
    public function numAssocArrayKsiazka($ksiazka, $quantity)
    {
        $this->ksiazki[$this->i]['isbn']=$ksiazka->getIsbn();        
        $this->ksiazki[$this->i]['tytul']=$ksiazka->getTytul();        
        $this->ksiazki[$this->i]['autor']=$ksiazka->getAutor();
        $this->ksiazki[$this->i]['cena']=$ksiazka->getCena();        
        $this->ksiazki[$this->i]['quantity']=$quantity;        
    }
    
    
    
    /**
     * Przygotowanie Zawartość Koszyka. 
     * - $ksiazki[] to dane o książkach w koszyku wraz z ilością.
     * - $suma
     * 
     * @return tablica $ksiazki i $suma
     * 
     */    
    public function przygotuj_zawartosc_koszyka()
    {
        foreach ($this->cart as $isbn => $quantity)
        {   
            $this->ksiazka = $this->getKsiazka($isbn);
            $this->numAssocArrayKsiazka($this->ksiazka, 
                    $quantity);
            
            // jeśli zmieniono ilość zamawianej książki w cartmenu. Gówno prawda, warunek jest prawdziwy dla każdego produktu w koszyku, nie tylko dla zmienionego. (Pod warunkiem, że kliknięto przycisk formularza z cartmenu.html.twig, Inaczej, tj gdy pierwszy raz przechodzę z cartmenuAction, ->request->has($isbn) nie będzie miał żadnego isbn)
            if($this->request->request->has($isbn)) // Co to?    - To jest to samo co w kontrolerze obiekt Request. W serwisach (a teraz jesteś w serwisie) nie można używać obiektu Request, zamiast tego jest obiekt RequestStack http://symfony.com/blog/new-in-symfony-2-4-the-request-stack
            {                                       // Ale co on if-uje?    -W cartmenu.html.twig jest <from> wyświetlający zawartość koszyka. Są w nim inputy ze zmienną o nazwie numeru ISBN konkretnej książki o jakiejś wartości. Formularz ten ma przycisk 'zatwierdź zmiany. Klikając przesyłam do path('cartmenu') metodą POST zmienne a w kontrolerze Symfony aktualizuje obiekt Request. A w tym serwisie obiekt RequestStack ma metodę '->request->has' którą sprawdzam zawartość obiektu jakie zmienne posiada. 
                $this->quantityUpdate($isbn);
            }

            $this->razem=$this->ksiazki[$this->i]['cena']*$this->ksiazki[$this->i]['quantity'];
            $this->suma+=$this->razem;
            $this->i++;
        }
        $this->setSumaSession();
    }

    protected function setSumaSession()
    {
        $this->session->set('suma',$this->suma );
    }


    /**
     * Usuwanie książki z koszyka
     * 
     */    
    function usun_ksiazke_z_koszyka($deleteisbn)
    {
        if(!($deleteisbn==''))
        { 
            unset($this->cart[$deleteisbn]);
            $this->session->set('cart',$this->cart );
        }
    }
    
    
    /**
     * zmiana ilości w cartmenu prowadzi przez skrypt JavaScript
     * do zmianaQuantityAction i tam jest wywoływana na funckcja.
     * 
     * @return tablica $ksiazki i $suma
     * 
     */    
    public function zmianaQuantityKoszyka()
    {
        foreach ($this->cart as $isbn => $quantity)
        {   
            $this->ksiazka = $this->getKsiazka($isbn);
            $this->numAssocArrayKsiazka($this->ksiazka, 
                    $quantity);
            
            // jeśli zmieniono ilość zamawianej książki w cartmenu. Gówno prawda, warunek jest prawdziwy dla każdego produktu w koszyku, nie tylko dla zmienionego. (Pod warunkiem, że kliknięto przycisk formularza z cartmenu.html.twig, Inaczej, tj gdy pierwszy raz przechodzę z cartmenuAction, ->request->has($isbn) nie będzie miał żadnego isbn)
            if($this->request->request->has($isbn)) // Co to?    - To jest to samo co w kontrolerze obiekt Request. W serwisach (a teraz jesteś w serwisie) nie można używać obiektu Request, zamiast tego jest obiekt RequestStack http://symfony.com/blog/new-in-symfony-2-4-the-request-stack
            {                                       // Ale co on if-uje?    -W cartmenu.html.twig jest <from> wyświetlający zawartość koszyka. Są w nim inputy ze zmienną o nazwie numeru ISBN konkretnej książki o jakiejś wartości. Formularz ten ma przycisk 'zatwierdź zmiany. Klikając przesyłam do path('cartmenu') metodą POST zmienne a w kontrolerze Symfony aktualizuje obiekt Request. A w tym serwisie obiekt RequestStack ma metodę '->request->has' którą sprawdzam zawartość obiektu jakie zmienne posiada. 
                $this->quantityUpdate($isbn);
            }

            $this->razem=$this->ksiazki[$this->i]['cena']*$this->ksiazki[$this->i]['quantity'];
            $this->suma+=$this->razem;
            $this->i++;
        } 
    } 
    
}