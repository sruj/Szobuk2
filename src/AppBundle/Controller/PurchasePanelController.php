<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\PurchaseType;
use AppBundle\Entity\Status;
use AppBundle\Exception\PurchaseNotFoundException;

class PurchasePanelController extends Controller
{

    /**
     * @Route("/panel/purchase-details/{purchaseid}/{userid}/", name="purchase_panel")
     * @Route("/panel/purchase-details/{purchaseid}/", defaults={"purchaseid": false}, name="manager_purchase_panel")
     */
    public function detailsAction(Request $request, $purchaseid = false, $userid = false)
    {
        $loggedUserId = $this->getUser()->getId();
        $adminLogged = $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        if (!(($loggedUserId == $userid) or ($adminLogged))) {
            throw $this->createAccessDeniedException();
        }

        if ($adminLogged) {
            $purchaseRepo = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->findoneBy(array('idpurchase' => $purchaseid));
            if (!$purchaseRepo) {
                throw new PurchaseNotFoundException('Nie ma w bazie danych szukanego zamówienia.');
            }
        }

        if (!$adminLogged) {
            $purchaseRepo = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->findoneBy(array('idpurchase' => $purchaseid, 'idclient' => $userid));
            if (!$purchaseRepo) {
                throw $this->createAccessDeniedException();
            }
        }

        $products = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseProduct')
            ->findBy(array('idpurchase' => $purchaseid));

        $statusForm = $this->createForm(PurchaseType::class, $purchaseRepo)->add('zmień status', 'submit');
        $statusForm->handleRequest($request);
        if ($statusForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($statusForm->getData());
            $em->flush();
        }

        return $this->render('AppBundle:PurchasePanel:details.html.twig', [
            'purchase' => $purchaseRepo, 'products' => $products,
            'statusForm' => $statusForm->createView()]);
    }
}
    