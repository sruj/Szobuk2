<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class KlientController extends Controller {

    /**
     * @Route("/historiaPanel", name="historiaZamowien")
     * @Template()
     */
    public function historiaPanelAction(Request $request) 
    {
        if
        (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $paginator  = $this->get('knp_paginator');
        
        $idLog = $this->getUser()->getId();

        $klient= $this->getDoctrine()
            ->getRepository('AppBundle:Klient')
            ->findOneBy(array('idlogowanie' => $idLog) );
        
        $idklient = $klient->getIdklient();

        $zam_rep = $this->get('app.zamowienie_repository');
        $zamowienia = $zam_rep->findAllMy($request->query->getInt('page', 1),$idklient);       
        
        return ['zamowienia' => $zamowienia];
    }
}
