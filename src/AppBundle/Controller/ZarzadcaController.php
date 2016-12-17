<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Manager\Filter;
use AppBundle\Utils\Manager\FilterQuery;
use AppBundle\Utils\Manager\Order;
use AppBundle\Utils\Manager\TableDetails;
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
use AppBundle\Utils\Manager\FormsManagerExtended;


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
        $tableDetails = new TableDetails();
        $tableDetails->setColumnsSortOrder($columnsSortOrder);
        $tableDetails->setColumnSort($columnSort);
        $tableDetails->setFilterField($filterField);
        $tableDetails->setQuery($query);
        $tableDetails->setFilter($filter);
        $tableDetails->setIdentifier($identifier);

        $sort = new Sort($tableDetails);
        $tableDetails->setColumnsSortOrder($sort->getColumnsSortOrder());

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


        $forms = new FormsManagerExtended($tmpForms);
        $fltrqry = new FilterQuery();

        $fltr = new Filter();
        $tds = $fltr->prepareFilterAndQuery($tableDetails, $forms, $fltrqry);
        $manager_order = $this->get('app.manager_order');
        $orders = $manager_order->prepareOrder($tds);
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
            'filterField' => $tableDetails->getFilterField(),
            'query' => $tableDetails->getQuery(),
            'identifier' => $tableDetails->getIdentifier(),
            'columnsSortOrder' => $tableDetails->getColumnsSortOrder(),
            'form' => $form->createView(),
            'StatusForm' => $StatusForm->createView(),
            'DataZamForm' => $DataZamForm->createView(),
            'NrKlientaForm' => $NrKlientaForm->createView(),
        ]);
    }


}