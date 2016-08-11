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
        
        //łączę entity Zamowienie ze Status by móc w szablonie sortować wg Status. Muszę tak robić gdyż tradycyjny zapis z.idstatus.status wywala błąd przy próbie sortowania według tegoż.
        $query = $em->createQuery('SELECT z,s FROM AppBundle:Zamowienie z JOIN z.idstatus s WHERE z.idklient = :idklient ORDER BY z.idzamowienie ASC');
        $query->setParameter('idklient', $idklient);

        $pagination = $paginator->paginate($query,$request->query->getInt('page', 1),91);        
//            echo '<pre>',print_r($klient),'</pre>'; 

        return array('pagination' => $pagination
        );
    }

}
