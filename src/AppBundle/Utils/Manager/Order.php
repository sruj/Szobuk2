<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-04
 * Time: 21:25
 */

namespace AppBundle\Utils\Manager;

use Doctrine\ORM\EntityManager;



class Order
{
    private $em;
    private $orders;
    private $tableDetails;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getTableDetails()
    {
        return $this->tableDetails;
    }

    public function getOrder()
    {
        return $this->orders;
    }

    public function prepareOrder(array $tableDetails, array $tmpForms)
    {
        $tableDetails = $this->setFalse($tableDetails, $tmpForms);
        $tableDetails = $this->setFilter($tableDetails, $tmpForms);
        $this->orders = $this->prepareRepository($tableDetails, $tmpForms);
    }
    

    private function setFalse($tb, $fms)
    {
        if ($this->isAnyFormValid($fms)){
            $tb['filterField'] = false;
            $tb['query'] = false;
        }

        if(!($tb['filterField']))
        {
            $tb['query'] = false;
        }

        return $tb;
    }
    
    private function setFilter($td,$forms)
    {
        if(!($td['filter']))
        {
            $td = $this->prepareFilterValue($forms,$td);
        }

        return $td;
    }

    private function prepareFilterValue($fms,$td){
        if($td['filterField']){
            $td['filter'] = $td['filterField'];
            return $td;
        }
        if($fms['StatusForm']->isValid()){
            $td['filter'] = 'idstatus';
            return $td;
        }
        if($fms['DataZamForm']->isValid()) {
            $td['filter'] = 'data';
            return $td;
        }
        if($fms['NrKlientaForm']->isValid()){
            $td['filter'] = 'idklient';
            return $td;
        }

        $td['filter'] = 'all';
        return $td;
    }


    private function isAnyFormValid($forms)
    {
        if(($forms['StatusForm']->isValid())or
            ($forms['DataZamForm']->isValid())or
            ($forms['NrKlientaForm']->isValid()))
        {
            return true;
        }
    }

    private function prepareRepository($td, $forms)
    {
        if($td['filter'] == 'all'){
            $repos = $this->orderRepositoryMakerAndSortArrChangerForAll($td);
            return $repos;
        }
        
        if($td['filter'] == 'idstatus'){
            $td = $this->prepareStatusFilter($td, $forms);
            $repos = $this->orderRepositoryMakerAndSortArrChangerNotForAll($td);
            return $repos;
        }

        if($td['filter'] == 'data') {
            $td = $this->prepareDataFilter($td, $forms);
            $repos = $this->orderRepositoryMakerAndSortArrChangerNotForAll($td);
            return $repos;
        }

        if($td['filter'] == 'idklient'){
            $td = $this->prepareKlientFilter($td, $forms);
            $repos = $this->orderRepositoryMakerAndSortArrChangerNotForAll($td);
            return $repos;
        }
        
        throw new \Exception('Nie można znaleźć zamówień dla '.$td['filter']);
    }
    
    private function orderRepositoryMakerAndSortArrChangerForAll($td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Zamowienie')
            ->findAllOrderedByY(
                $td['columnsSortOrder'],
                $td['columnSort']);
        if (!$repo) {throw new \Exception('Nie można znaleźć zamówień');}

        return $repo;
    }

    private function orderRepositoryMakerAndSortArrChangerNotForAll($td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Zamowienie')
            ->findByXOrderedByY(
                $td['query'],
                $td['columnsSortOrder'],
                $td['columnSort']);
        if (!$repo) {throw new \Exception('Nie można znaleźć zamówień');}

        return $repo;
    }


    private function prepareStatusFilter($td, $forms)
    {
        if((!$td['query']) and (!$td['identifier'])) {
            $td['identifier'] = $forms['StatusForm']->get('status')->getData()->getIdstatus();
        }
        
        if((!$td['query']) and ($td['identifier'])) {
            $td['query'] = 'idstatus = ' . $td['identifier'];
        }

        $td['filterField'] = 'idstatus';

        return $td;
    }

    private function prepareDataFilter($td, $forms)
    {
        if($td['query']) {
            $td['query'] = urldecode($td['query']);
        }

        if (!$td['query']) {
            $od = $forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
            $do = $forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
            $td['query'] = "datazlozenia BETWEEN '" . $od . "' AND '" . $do . "'";
        }

        $td['filterField'] = 'data';
        $td['query'] = urlencode($td['query']);

        return $td;
    }

    private function prepareKlientFilter($td, $forms)
    {
        if ((!($td['query'])) and (!$td['identifier'])) {
            $td['identifier'] = $forms['NrKlientaForm']->get('idklient')->getData()->getIdklient();
            return $td;
        }

        if ((!($td['query'])) and $td['identifier']) {
            $td['query'] = 'idklient = ' . $td['identifier'];
            return $td;
        }

        return $td;
    }

}
