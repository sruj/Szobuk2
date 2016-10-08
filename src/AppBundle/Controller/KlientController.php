<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class KlientController extends Controller {

    /**
     * @Route("/historiaPanel", name="historiaZamowien")
     */
    public function historiaPanelAction(Request $request) 
    {
        if
        (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $klient= $this->getDoctrine()
            ->getRepository('AppBundle:Klient')
            ->findOneBy(['idlogowanie' => $this->getUser()->getId()]);
        
        $idklient = $klient->getIdklient();

        $zam_rep = $this->get('app.zamowienie_repository');
        $zamowienia = $zam_rep->findAllMy($request->query->getInt('page', 1),$idklient);

        return $this->render('AppBundle:Klient:historiaPanel.html.twig',[
            'zamowienia' => $zamowienia
        ]);
    }
}
