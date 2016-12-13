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
    public function prepareFilterAndQuery(TableDetails $td, FormsManagerExtended $forms, IFilterQuery $fq)
    {
        $td = $this->prepareDetails($td,$forms);
        $tds = $this->makeFilterAndQuery($td,$forms,$fq);

        return $tds;
    }

    
    private function prepareDetails(TableDetails $tableDetails,FormsManagerExtended $tmpForms)
    {
        $tableDetails = $this->setFalse($tableDetails, $tmpForms);
        $tableDetails = $this->setFilter($tableDetails, $tmpForms);

        return $tableDetails;
    }
    
    private function makeFilterAndQuery(TableDetails $td,FormsManagerExtended $forms, IFilterQuery $fq)
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

    private function setFalse(TableDetails $tb, FormsManagerExtended $fms)
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

    
    private function isAnyFormValid(FormsManager $forms)
    {
        return $forms->isAnyFormValid();
    }

    private function setFilter(TableDetails $td,$forms)
    {
        if(!($td->getFilter()))
        {
            $td = $this->prepareFilterValue($forms,$td);
        }

        return $td;
    }

    
    private function prepareFilterValue(FormsManagerExtended $fms,TableDetails $td){
        if($td->getFilterField()){
            $td->setFilter($td->getFilterField());
            return $td;
        }
        if($fms->isStatusFormValid()){
            $td->setFilter('idstatus');
            return $td;
        }
        if($fms->isDataZamFormValid()) {
            $td->setFilter('data');
            return $td;
        }
        if($fms->isNrKlientaFormValid()){
            $td->setFilter('idklient');
            return $td;
        }

        $td->setFilter('all');
        return $td;
    }
}