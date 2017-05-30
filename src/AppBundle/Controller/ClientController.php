<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Exception\ClientHasNoShoppingHistory;

class ClientController extends Controller {

    /**
     * @Route("/order-history", name="order_history")
     */
    public function historiaPanelAction(Request $request) 
    {
        if
        (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $client= $this->getDoctrine()
            ->getRepository('Client.php')
            ->findOneBy(['idlogowanie' => $this->getUser()->getId()]);
        
        if(!$client){
            throw new ClientHasNoShoppingHistory('Nie masz zapisanej historii zakupów.');
        }

        $idClient = $client->getIdklient();

        $rep = $this->get('app.order_repository');
        $orders = $rep->findAllMy($request->query->getInt('page', 1),$idClient);

        return $this->render('AppBundle:Client:order_history.html.twig',[
            'orders' => $orders
        ]);
    }
}
