<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\ZamowienieType;
use AppBundle\Entity\Status;
use AppBundle\Exception\OrderNotFoundException;


class PanelZamowieniaSzczegolyController extends Controller {

    /**
     * @Route("/panel/szczegoly-zamowienia/{idzamowienie}/{userid}/", name="panelDetails")
     * @Route("/panel/szczegoly-zamowienia/{idzamowienie}/", name="ZarzadcaPanelDetails")
     */
    public function detailsAction(Request $request, $idzamowienie = false, $userid = false) 
    {
        $LoggedUserId = $this->getUser()->getId();
        $adminLogged = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        if(!(($LoggedUserId==$userid)or($adminLogged))){
           throw $this->createAccessDeniedException(); 
        }
        
        if($adminLogged)
        {
            $zamowienieRep = $this->getDoctrine()
                ->getRepository('AppBundle:Zamowienie')
                ->findoneBy(array('idzamowienie' => $idzamowienie));
            if (!$zamowienieRep) {
                throw new OrderNotFoundException('Nie ma w bazie danych szukanego zamówienia.');
            }
        }

        if(!$adminLogged)
        {
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

        $StatusForm = $this->createForm(ZamowienieType::class, $zamowienieRep)->add('zmień status', 'submit');
        $StatusForm->handleRequest($request);
        if ($StatusForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($StatusForm->getData());
            $em->flush();
        }

        return $this->render('AppBundle:PanelZamowieniaSzczegoly:details.html.twig',[
            'zamowienie' => $zamowienieRep, 'produkty' => $produkty,
            'StatusForm' => $StatusForm->createView()]);
    }
}
    