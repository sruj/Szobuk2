<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Manager\Filter;
use AppBundle\Utils\Manager\FilterQuery;
use AppBundle\Utils\Manager\TableDetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PurchaseType;
use AppBundle\Form\PurchaseListType;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseList;
use AppBundle\Entity\Status;
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\Filter\DataZamType;
use AppBundle\Form\Filter\NrKlientaType;
use AppBundle\Utils\Manager\Sort;
use AppBundle\Utils\Manager\FormsManagerExtended;

/**
 * @Route("/manager")
 */
class ManagerController extends Controller
{
    /**
     * @Route("/", name="manager_menu")
     */
    public function menuAction()
    {
        return $this->render('AppBundle:Manager:menu.html.twig', []);
    }

    /**
     * @Route("/panel/{filter}-{identifier}", name="panel_sort_from_details",
     *      defaults={
     *     "filter": false,
     *     "identifier": false,
     *     "columnsSortOrder": false,
     *     "columnSort": "idpurchase",
     *     "query": false,
     *     "filterField": false,
     *     })
     * @Route("/panel/{columnsSortOrder}/{columnSort}/{query}/{filterField}", name="panel_sort",
     *      defaults={
     *     "filter": false,
     *     "identifier": false,
     *     "columnsSortOrder": false,
     *     "columnSort": "idpurchase",
     *     "query": false,
     *     "filterField": false,
     *     })
     */
    public function panelSortAction(Request $request, $columnsSortOrder, $columnSort, $query, $filterField, $filter, $identifier)
    {
        $tableDetails = new TableDetails();
        $tableDetails->setColumnsSortPurchase($columnsSortOrder);
        $tableDetails->setColumnSort($columnSort);
        $tableDetails->setFilterField($filterField);
        $tableDetails->setQuery($query);
        $tableDetails->setFilter($filter);
        $tableDetails->setIdentifier($identifier);

        $sort = new Sort($tableDetails);
        $tableDetails->setColumnsSortPurchase($sort->getColumnsSortPurchase());

        $statusForm = $this->createForm(StatusType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));
        $purchaseDataorm = $this->createForm(DataZamType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));
        $clientaNumberForm = $this->createForm(NrKlientaType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));

        $statusForm->handleRequest($request);
        $purchaseDataorm->handleRequest($request);
        $clientaNumberForm->handleRequest($request);

        $tmpForms = [
            'StatusForm' => $statusForm,
            'PurchaseDateForm' => $purchaseDataorm,
            'ClientNumberForm' => $clientaNumberForm,
        ];

        $forms = new FormsManagerExtended($tmpForms);
        $fltrqry = new FilterQuery();
        $fltr = new Filter();
        $managerPurchase = $this->get('app.manager_purchase');

        $tds = $fltr->prepareFilterAndQuery($tableDetails, $forms, $fltrqry);
        $purchases = $managerPurchase->preparePurchase($tds);
        $tableDetails = $managerPurchase->getTableDetails();

        $purchasesProducts = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseProduct')
            ->findAll();

        $purchasesList = new PurchaseList();
        foreach ($purchases as $purchase) {
            $purchasesList->getPurchases()->add($purchase);
        }

        $form = $this->createForm(PurchaseListType::class, $purchasesList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData() as $task) {
                $em->merge($task);
            }
            $em->flush();
        }

        return $this->render('AppBundle:Manager:panel_sort.html.twig', [
            'purchasesProducts' => $purchasesProducts,
            'filterField' => $tableDetails->getFilterField(),
            'query' => $tableDetails->getQuery(),
            'identifier' => $tableDetails->getIdentifier(),
            'columnsSortOrder' => $tableDetails->getColumnsSortPurchase(),
            'form' => $form->createView(),
            'StatusForm' => $statusForm->createView(),
            'PurchaseDateForm' => $purchaseDataorm->createView(),
            'ClientNumberForm' => $clientaNumberForm->createView(),
        ]);
    }
}