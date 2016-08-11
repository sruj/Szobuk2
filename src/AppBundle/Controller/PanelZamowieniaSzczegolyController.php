<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\ZamowienieType;
use AppBundle\Entity\Status;


class PanelZamowieniaSzczegolyController extends Controller {

    /**
     * @Route("/panel/szczegoly-zamowienia/{idzamowienie}/{userid}/", name="panelDetails")
     * @Route("/panel/szczegoly-zamowienia/{idzamowienie}/", name="ZarzadcaPanelDetails")
     * @Template()
     */
    public function detailsAction(Request $request, $idzamowienie = false, $userid = false) 
    {
        //sprawdzam czy użytkownik ma prawo do oglądania strony (zapobieżenie by nieuprawniony klient oglądał nie swoje zamówienia )
        $LoggedUserId = $this->getUser()->getId();
        $adminLogged = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        if(!(($LoggedUserId==$userid)or($adminLogged))){
           throw $this->createAccessDeniedException(); 
        }
        
        if($adminLogged){
            $zamowienieRep = $this->getDoctrine()
                ->getRepository('AppBundle:Zamowienie')
                ->findoneBy(array('idzamowienie' => $idzamowienie));
            
            if (!$zamowienieRep) {
                throw new \Exception('Nie ma w bazie danych szukanego zamówienia.');
            }
        }else{
            $zamowienieRep = $this->getDoctrine()
                ->getRepository('AppBundle:Zamowienie')
                ->findoneBy(array('idzamowienie' => $idzamowienie,'idklient' => $userid));
        
            if(!$zamowienieRep){
               throw $this->createAccessDeniedException(); 
            }        
        }  
        
        
        $produkty = $this->getDoctrine()
                ->getRepository('AppBundle:ZamowienieProdukt')
                ->findBy(array('idzamowienie' => $idzamowienie));

        $StatusForm = $this->createForm(new ZamowienieType(), $zamowienieRep)->add('zmień status', 'submit');
        //[-Formularze-]Jeśli wypełniłem formularz to odbieram zawartość
        $StatusForm->handleRequest($request);
        if ($StatusForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($StatusForm->getData());
            $em->flush();
        }

        return array('zamowienie' => $zamowienieRep, 'produkty' => $produkty,
            'StatusForm' => $StatusForm->createView());
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * @Route("/testtt")
     * @Template()
     */
    public function testttAction() 
    {

        
        $klient= $this->getDoctrine()
            ->getRepository('AppBundle:Klient')
            ->findOneBy(array('idlogowanie' => 2) );
        
        
        $zamowienie = $this->getDoctrine()
            ->getRepository('AppBundle:Zamowienie')
            ->find(43);
        
                //sprawdzam czy id klienta zalogowanego użytkownika tożsame jest z id klienta 
//        $klient= $this->getDoctrine()
//            ->getRepository('AppBundle:Klient')
//            ->findOneBy(array('idlogowanie' => $LoggedUserId) );
//        $idklientK = $klient->getIdklient();
//        
//        $idZam = $zamowienie;    
//        
//        $idklientZ = $zamowienie->getIdklient()->getIdklient();
//         
//        if(!($idklientZ==$idklientK)){
//           throw $this->createAccessDeniedException(); 
//        }
        
      

         
        
        echo $klient->getIdklient();
        echo $zamowienie->getIdklient()->getIdklient();
        
        return array('zamowienie' => $zamowienie, 'klient' => $klient);
    }
    
    
    
    
    
    
    
}
