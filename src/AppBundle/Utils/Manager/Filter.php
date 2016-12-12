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
    public function prepareFilterAndQuery(TableDetails $td, $forms, IFilterQuery $fq)
    {
        $td = $this->prepareDetails($td,$forms);
        $tds = $this->makeFilterAndQuery($td,$forms,$fq);

        return $tds;
    }

    
    private function prepareDetails(TableDetails $tableDetails, array $tmpForms)
    {
        $tableDetails = $this->setFalse($tableDetails, $tmpForms);
        $tableDetails = $this->setFilter($tableDetails, $tmpForms);

        return $tableDetails;
    }
    
    private function makeFilterAndQuery(TableDetails $td, $forms, IFilterQuery $fq)
    {
        if($td->getFilter() == 'all'){
            return $td;
        }

        if($td->getFilter() == 'idstatus'){
            $td->setFilterField('idstatus');
            $tds = $fq->prepareStatusFilterQuery($td, $forms);
            return $tds;
        }

        if($td->getFilter() == 'data') {
            $td->setFilterField('data');
            $tds = $fq->prepareDataFilterQuery($td, $forms);
            return $tds;
        }

        if($td->getFilter() == 'idklient'){
            $tds = $fq->prepareKlientFilterQuery($td, $forms);
            return $tds;
        }
    }

    private function setFalse(TableDetails $tb, $fms)
    {
        if ($this->isAnyFormValid($fms)){
            $tb->setFilterField(false);
            $tb->setQuery(false);
        }

        if(!($tb->getFilterField()))
        {
            $tb->setQuery(false);
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

    private function setFilter(TableDetails $td,$forms)
    {
        if(!($td->getFilter()))
        {
            $td = $this->prepareFilterValue($forms,$td);
        }

        return $td;
    }

    private function prepareFilterValue($fms,TableDetails $td){
        if($td->getFilterField()){
            $td->setFilter($td->getFilterField());
            return $td;
        }
        if($fms['StatusForm']->isValid()){
            $td->setFilter('idstatus');
            return $td;
        }
        if($fms['DataZamForm']->isValid()) {
            $td->setFilter('data');
            return $td;
        }
        if($fms['NrKlientaForm']->isValid()){
            $td->setFilter('idklient');
            return $td;
        }

        $td->setFilter('all');
        return $td;
    }
}