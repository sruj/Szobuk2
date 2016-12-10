<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-04
 * Time: 21:25
 */

namespace AppBundle\Utils\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Utils\Manager\Filter;



class Order
{
    private $em;
    private $orders;
    private $tableDetails;
    private $ftr;

    function __construct(EntityManager $em, Filter $ftr)
    {
        $this->em = $em;
        $this->ftr = $ftr;
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
            $repos = $this->orderRepositoryMakerForAll($td);
            return $repos;
        }
        
        if($td['filter'] == 'idstatus'){
            $td = $this->ftr->prepareStatusFilter($td, $forms);
            $repos = $this->orderRepositoryMakerNotForAll($td);
            return $repos;
        }

        if($td['filter'] == 'data') {
            $td = $this->ftr->prepareDataFilter($td, $forms);
            $repos = $this->orderRepositoryMakerNotForAll($td);
            return $repos;
        }

        if($td['filter'] == 'idklient'){
            $td = $this->ftr->prepareKlientFilter($td, $forms);
            $repos = $this->orderRepositoryMakerNotForAll($td);
            return $repos;
        }
        
        throw new \Exception('Nie można znaleźć zamówień dla '.$td['filter']);
    }
    
    private function orderRepositoryMakerForAll($td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Zamowienie')
            ->findAllOrderedByY(
                $td['columnsSortOrder'],
                $td['columnSort']);
        if (!$repo) {throw new \Exception('Nie można znaleźć zamówień');}

        return $repo;
    }

    private function orderRepositoryMakerNotForAll($td)
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




}
