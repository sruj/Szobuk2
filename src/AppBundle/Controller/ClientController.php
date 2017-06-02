<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Exception\ClientHasNoShoppingHistory;

class ClientController extends Controller {

    /**
     * @Route("/purchase-history", name="purchase_history")
     */
    public function historyPanelAction(Request $request)
    {
        if
        (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $client= $this->getDoctrine()
            ->getRepository('AppBundle:Client')
            ->findOneBy(['idlogin' => $this->getUser()->getId()]);
        
        if(!$client){
            throw new ClientHasNoShoppingHistory('Nie masz zapisanej historii zakupów.');
        }

        $idClient = $client->getIdclient();

        $rep = $this->get('app.purchase_repository');
        $purchases = $rep->findAllMy($request->query->getInt('page', 1),$idClient);

        return $this->render('AppBundle:Client:purchase_history.html.twig',[
            'purchases' => $purchases
        ]);
    }
}
