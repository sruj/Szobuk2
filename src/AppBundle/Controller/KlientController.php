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
        //refaktor: Type error: Argument 2 passed to Doctrine\ORM\EntityRepository::__construct() must be an instance of Doctrine\ORM\Mapping\ClassMetadata, none given, called in C:\wamp64\www\Szobuk2\app\cache\dev\appDevDebugProjectContainer.php on line 455
        //500 Internal Server Error - FatalThrowableError        
        
        
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
