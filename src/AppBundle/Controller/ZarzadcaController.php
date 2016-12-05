<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ZamowienieType;
use AppBundle\Form\ZamowienieListType;
use AppBundle\Entity\Zamowienie;
use AppBundle\Entity\ZamowienieList;
use AppBundle\Entity\Status;
use AppBundle\Form\Filter\StatusType;
use AppBundle\Form\Filter\DataZamType;
use AppBundle\Form\Filter\NrKlientaType;
use AppBundle\Utils\Manager\Sort;

/**
 * Kategoria controller.
 *
 * @Route("/zarzadca")
 */
class ZarzadcaController extends Controller
{
    /**
     * @Route("/", name="menuZarzadca")
     */
    public function menuAction()
    {
        return $this->render('AppBundle:Zarzadca:menu.html.twig',[]);
    }

    /**
     * @Route("/panel/{filter}-{identifier}", name="panelSortFromDetails",
     *      defaults={
     *     "filter": false,
     *     "identifier": false,
     *     "columnsSortOrder": false,
     *     "columnSort": "idzamowienie",
     *     "query": false,
     *     "filterField": false,
     *     })
     * @Route("/panel/{columnsSortOrder}/{columnSort}/{query}/{filterField}", name="panelSort",
     *      defaults={
     *     "filter": false,
     *     "identifier": false,
     *     "columnsSortOrder": false,
     *     "columnSort": "idzamowienie",
     *     "query": false,
     *     "filterField": false,
     *     })
     */
    public function panelsortAction(Request $request, $columnsSortOrder, $columnSort, $query, $filterField, $filter, $identifier)
    {
        $tableDetails = [
            'columnsSortOrder' => $columnsSortOrder,
            'columnSort' => $columnSort,
            'filterField' => $filterField,
            'query' => $query,
            'filter' => $filter,
            'identifier' => $identifier,
        ];

        $sort = new Sort($tableDetails);
        $tableDetails['columnsSortOrder'] = $sort->getColumnsSortOrder();

        $StatusForm = $this->createForm(StatusType::class,null, array(
            'action' => $this->generateUrl('panelSortFromDetails')));
        $DataZamForm = $this->createForm(DataZamType::class,null, array(
            'action' => $this->generateUrl('panelSortFromDetails')));
        $NrKlientaForm = $this->createForm(NrKlientaType::class,null, array(
            'action' => $this->generateUrl('panelSortFromDetails')));

        $StatusForm->handleRequest($request);
        $DataZamForm->handleRequest($request);
        $NrKlientaForm->handleRequest($request);

        $tmpForms = [
            'StatusForm' => $StatusForm,
            'DataZamForm' => $DataZamForm,
            'NrKlientaForm' => $NrKlientaForm,
        ];

        $manager_order = $this->get('app.manager_order');
        $manager_order->prepareOrder($tableDetails, $tmpForms);
        $orders = $manager_order->getOrder();
        $tableDetails = $manager_order->getTableDetails();

        $ordersProducts= $this->getDoctrine()
            ->getRepository('AppBundle:ZamowienieProdukt')
            ->findAll();

        $ordersList = new ZamowienieList();
        foreach ($orders as $zamowienie) {
            $ordersList->getZamowienia()->add($zamowienie);
        }

        $form = $this->createForm(ZamowienieListType::class, $ordersList);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($form->getData() as $task) {
                $em->merge($task);
            }
            $em->flush();
        }

        return $this->render('AppBundle:Zarzadca:panelsort.html.twig',[
            'zamowieniaProdukty'=>$ordersProducts,
            'filterField' => $tableDetails['filterField'],
            'query' => $tableDetails['query'],
            'identifier' => $tableDetails['identifier'],
            'columnsSortOrder' => $tableDetails['columnsSortOrder'],
            'form' => $form->createView(),
            'StatusForm' => $StatusForm->createView(),
            'DataZamForm' => $DataZamForm->createView(),
            'NrKlientaForm' => $NrKlientaForm->createView(),
        ]);
    }


}