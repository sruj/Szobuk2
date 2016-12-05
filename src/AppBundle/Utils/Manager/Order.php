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
    private $forms;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function prepareOrder($tableDetails, $tmpForms)
    {
        $this->setFields($tableDetails, $tmpForms);
     
        $this->setFalse();
        $this->setFilter();
        
        $this->prepareRepository();
        
        
        
    }
    
    private function setFields(array $fields, array $forms)
    {
        $this->tableDetails = $fields;
        $this->forms = $forms;
    }

    private function setFalse()
    {
        if ($this->isAnyFormValid()){
            $this->tableDetails['filterField'] = false;
            $this->tableDetails['query'] = false;
        }

        if(!($this->tableDetails['filterField']))
        {
            $this->tableDetails['query'] = false;
        }
    }
    
    private function setFilter()
    {
        if(!($this->tableDetails['filter']))
        {
            $this->prepareFilterValue();
        }
    }

    private function prepareFilterValue(){
        if(!($this->tableDetails['filterField'])){
            if($this->forms['StatusForm']->isValid()){ $this->tableDetails['filter'] = 'idstatus';}
            elseif($this->forms['DataZamForm']->isValid()){ $this->tableDetails['filter'] = 'data';}
            elseif($this->forms['NrKlientaForm']->isValid()){ $this->tableDetails['filter'] = 'idklient';}
            else{ $this->tableDetails['filter'] = 'all';}
        }else{$this->tableDetails['filter'] = $this->tableDetails['filterField'] ;}
    }



    private function isAnyFormValid()
    {
        if(($this->forms['StatusForm']->isValid())or
            ($this->forms['DataZamForm']->isValid())or
            ($this->forms['NrKlientaForm']->isValid()))
        {
            return 1;
        }
    }

    private function prepareRepository()
    {
        if($this->tableDetails['filter'] == 'all'){
            $this->orderRepositoryMakerAndSortArrChangerForAll();
        }elseif($this->tableDetails['filter'] == 'idstatus'){
            if(!($this->tableDetails['query'])){
                if(!$this->tableDetails['identifier']){
                    $this->tableDetails['identifier'] = $this->forms['StatusForm']->get('status')->getData();
                    $this->tableDetails['identifier'] = $this->tableDetails['identifier']->getIdstatus();
                }
                $this->tableDetails['query'] = 'idstatus = '.$this->tableDetails['identifier'];
            }
            $this->tableDetails['filterField'] = 'idstatus';
            $this->orderRepositoryMakerAndSortArrChangerNotForAll();

        }
        elseif($this->tableDetails['filter'] == 'data'){
            if(!($this->tableDetails['query'])){
                $od = $this->forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
                $do = $this->forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
                $this->tableDetails['query'] = "datazlozenia BETWEEN '".$od."' AND '".$do."'";
            }  else {
                $this->tableDetails['query'] = urldecode($this->tableDetails['query']);

            }
            $this->tableDetails['filterField'] = 'data';
            $this->orderRepositoryMakerAndSortArrChangerNotForAll();
            $this->tableDetails['query'] = urlencode($this->tableDetails['query']);

        }elseif($this->tableDetails['filter'] == 'idklient'){
            if(!($this->tableDetails['query'])){
                if(!$this->tableDetails['identifier']){
                    $this->tableDetails['identifier'] = $this->forms['NrKlientaForm']->get('idklient')->getData();
                    $this->tableDetails['identifier'] = $this->tableDetails['identifier']->getIdklient();
                }
                $this->tableDetails['query'] = 'idklient = '.$this->tableDetails['identifier'];
            }
            $this->orderRepositoryMakerAndSortArrChangerNotForAll();
        }else{
            throw new \Exception('Nie można znaleźć zamówień dla '.$this->tableDetails['filter']);
        }        
    }
    
    private function orderRepositoryMakerAndSortArrChangerForAll()
    {
        $this->orders = $this->em->getRepository('AppBundle:Zamowienie')
            ->findAllOrderedByY(
                $this->tableDetails['columnsSortOrder'], 
                $this->tableDetails['columnSort']);
        if (!$this->orders) {throw new \Exception('Nie można znaleźć zamówień');}
    }

    private function orderRepositoryMakerAndSortArrChangerNotForAll()
    {
        $this->orders = $this->em->getRepository('AppBundle:Zamowienie')
            ->findByXOrderedByY(
                $this->tableDetails['query'],
                $this->tableDetails['columnsSortOrder'], 
                $this->tableDetails['columnSort']);
        if (!$this->orders) {throw new \Exception('Nie można znaleźć zamówień');}
    }


    public function getTableDetails()
    {
        return $this->tableDetails;
    }
    
    public function getOrder()
    {
        return $this->orders;
    }
}
