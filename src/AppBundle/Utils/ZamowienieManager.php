<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:53
 */

namespace AppBundle\Utils;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Klient;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\ZamowienieProdukt;
use AppBundle\Entity\Status;
use AppBundle\Entity\Ksiazka;

class ZamowienieManager
{
    private $storage;
    private $checker;
    private $session;
    private $cart;
    private $em;

    /**
     * ZamowienieManager constructor.
     */
    public function __construct(EntityManager $em, 
                                TokenStorage $storage, 
                                AuthorizationCheckerInterface $checker, 
                                Session $session)
    {
        $this->em = $em;
        $this->storage = $storage;
        $this->checker = $checker;
        $this->session = $session;
        $this->cart = $this->session->get('cart');
    }

    public function tworzZamowienie($klient)
    {
        //linijka dla zalogowanego użytkownika
        if ($this->checker->isGranted('IS_AUTHENTICATED_FULLY')){
            $klient->setIdlogowanie($this->getUser());
        }

        //wypełnienie tabeli Zamowienie
        $zamowienie = new Zamowienie();
        $zamowienie->setIdklient($klient);
        $status = $this->em
            ->getRepository('AppBundle:Status')
            ->find('1');
        $zamowienie->setIdstatus($status);
        $zamowienie->setDatazlozeniacurrent();
        
        $this->tworzProduktyZamowienia($zamowienie);

        $this->em->persist($klient);
        $this->em->persist($zamowienie);
        $this->em->flush();

        $this->addFlashBag($zamowienie);//refaktor: tu mozna listener
        
    }
    
    private function getUser()
    {
        return $this->storage->getToken()->getUser();
    }

    private function tworzProduktyZamowienia($zamowienie)
    {
        foreach ($this->cart as $isbn => $quantity)
        {
            $ksiazka = $this->em
                ->getRepository('AppBundle:Ksiazka')
                ->find($isbn);
            $tytul=$ksiazka->getTytul();
            $autor=$ksiazka->getAutor();
            $cena=$ksiazka->getCena();
            $rokwydania=$ksiazka->getRokwydania();
            $zm = new ZamowienieProdukt();
            $zm->setIdzamowienie($zamowienie);
            $zm->setIsbn($ksiazka);
            $zm->setTytul($tytul);
            $zm->setAutor($autor);
            $zm->setCenaproduktu($cena);
            $zm->setRokwydania($rokwydania);
            $zm->setIlosc($quantity);
            $this->em->persist($zm);
        }
    }
    
    public function addFlashBag($zamowienie){
        $idzamowienia = $zamowienie->getIdzamowienie();
        $this->session->getFlashBag()->add(
            'idzamowienie',
            $idzamowienia);
    }

    
}