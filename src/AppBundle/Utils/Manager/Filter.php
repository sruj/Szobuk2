<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-10
 * Time: 23:41
 */

namespace AppBundle\Utils\Manager;

use AppBundle\Utils\Manager\IFilterQuery;

class Filter
{
    public function prepareFilterAndQuery($td, $forms, IFilterQuery $fq)
    {
        $td = $this->prepareDetails($td,$forms);
        $tds = $this->makeFilterAndQuery($td,$forms,$fq);

        return $tds;

    }

    
    private function prepareDetails(array $tableDetails, array $tmpForms)
    {
        $tableDetails = $this->setFalse($tableDetails, $tmpForms);
        $tableDetails = $this->setFilter($tableDetails, $tmpForms);

        return $tableDetails;
    }
    
    private function makeFilterAndQuery($td, $forms, IFilterQuery $fq)
    {
        if($td['filter'] == 'all'){
            return $td;
        }

        if($td['filter'] == 'idstatus'){
            $td['filterField'] = 'idstatus';
            $tds = $fq->prepareStatusFilterQuery($td, $forms);
            return $tds;
        }

        if($td['filter'] == 'data') {
            $td['filterField'] = 'data';
            $tds = $fq->prepareDataFilterQuery($td, $forms);
            return $tds;
        }

        if($td['filter'] == 'idklient'){
            $tds = $fq->prepareKlientFilterQuery($td, $forms);
            return $tds;
        }
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

    private function isAnyFormValid($forms)
    {
        if(($forms['StatusForm']->isValid())or
            ($forms['DataZamForm']->isValid())or
            ($forms['NrKlientaForm']->isValid()))
        {
            return true;
        }

        return false;
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
}