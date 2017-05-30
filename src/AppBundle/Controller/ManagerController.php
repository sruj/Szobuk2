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
use AppBundle\Form\OrderType;
use AppBundle\Form\OrderListType;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderList;
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
     *     "columnSort": "idzamowienie",
     *     "query": false,
     *     "filterField": false,
     *     })
     * @Route("/panel/{columnsSortOrder}/{columnSort}/{query}/{filterField}", name="panel_sort",
     *      defaults={
     *     "filter": false,
     *     "identifier": false,
     *     "columnsSortOrder": false,
     *     "columnSort": "idzamowienie",
     *     "query": false,
     *     "filterField": false,
     *     })
     */
    public function panelSortAction(Request $request, $columnsSortOrder, $columnSort, $query, $filterField, $filter, $identifier)
    {
        $tableDetails = new TableDetails();
        $tableDetails->setColumnsSortOrder($columnsSortOrder);
        $tableDetails->setColumnSort($columnSort);
        $tableDetails->setFilterField($filterField);
        $tableDetails->setQuery($query);
        $tableDetails->setFilter($filter);
        $tableDetails->setIdentifier($identifier);

        $sort = new Sort($tableDetails);
        $tableDetails->setColumnsSortOrder($sort->getColumnsSortOrder());

        $statusForm = $this->createForm(StatusType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));
        $orderDataorm = $this->createForm(DataZamType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));
        $clientaNumberForm = $this->createForm(NrKlientaType::class, null, array(
            'action' => $this->generateUrl('panel_sort_from_details')));

        $statusForm->handleRequest($request);
        $orderDataorm->handleRequest($request);
        $clientaNumberForm->handleRequest($request);

        $tmpForms = [
            'StatusForm' => $statusForm,
            'DataZamForm' => $orderDataorm,
            'NrKlientaForm' => $clientaNumberForm,
        ];

        $forms = new FormsManagerExtended($tmpForms);
        $fltrqry = new FilterQuery();
        $fltr = new Filter();
        $managerOrder = $this->get('app.manager_order');

        $tds = $fltr->prepareFilterAndQuery($tableDetails, $forms, $fltrqry);
        $orders = $managerOrder->prepareOrder($tds);
        $tableDetails = $managerOrder->getTableDetails();

        $ordersProducts = $this->getDoctrine()
            ->getRepository('OrderProduct.php')
            ->findAll();

        $ordersList = new OrderList();
        foreach ($orders as $order) {
            $ordersList->getZamowienia()->add($order);
        }

        $form = $this->createForm(OrderListType::class, $ordersList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData() as $task) {
                $em->merge($task);
            }
            $em->flush();
        }

        return $this->render('AppBundle:Manager:panel_sort.html.twig', [
            'zamowieniaProdukty' => $ordersProducts,
            'filterField' => $tableDetails->getFilterField(),
            'query' => $tableDetails->getQuery(),
            'identifier' => $tableDetails->getIdentifier(),
            'columnsSortOrder' => $tableDetails->getColumnsSortOrder(),
            'form' => $form->createView(),
            'StatusForm' => $statusForm->createView(),
            'DataZamForm' => $orderDataorm->createView(),
            'NrKlientaForm' => $clientaNumberForm->createView(),
        ]);
    }
}