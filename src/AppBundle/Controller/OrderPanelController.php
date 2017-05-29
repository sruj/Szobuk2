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

class OrderPanelController extends Controller
{

    /**
     * @Route("/panel/order-details/{orderid}/{userid}/", name="order_panel")
     * @Route("/panel/order-details/{orderid}/", name="manager_order_panel")
     */
    public function detailsAction(Request $request, $orderid = false, $userid = false)
    {
        $loggedUserId = $this->getUser()->getId();
        $adminLogged = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        if (!(($loggedUserId == $userid) or ($adminLogged))) {
            throw $this->createAccessDeniedException();
        }

        if ($adminLogged) {
            $orderRepo = $this->getDoctrine()
                ->getRepository('AppBundle:Zamowienie')
                ->findoneBy(array('idzamowienie' => $orderid));
            if (!$orderRepo) {
                throw new OrderNotFoundException('Nie ma w bazie danych szukanego zamówienia.');
            }
        }

        if (!$adminLogged) {
            $orderRepo = $this->getDoctrine()
                ->getRepository('AppBundle:Zamowienie')
                ->findoneBy(array('idzamowienie' => $orderid, 'idklient' => $userid));
            if (!$orderRepo) {
                throw $this->createAccessDeniedException();
            }
        }

        $products = $this->getDoctrine()
            ->getRepository('AppBundle:ZamowienieProdukt')
            ->findBy(array('idzamowienie' => $orderid));

        $statusForm = $this->createForm(ZamowienieType::class, $orderRepo)->add('zmień status', 'submit');
        $statusForm->handleRequest($request);
        if ($statusForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($statusForm->getData());
            $em->flush();
        }

        return $this->render('AppBundle:OrderPanel:details.html.twig', [
            'order' => $orderRepo, 'products' => $products,
            'statusForm' => $statusForm->createView()]);
    }
}
    