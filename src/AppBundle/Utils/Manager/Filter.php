<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-10
 * Time: 23:41
 */

namespace AppBundle\Utils\Manager;

use AppBundle\Utils\Manager\IFilterQuery;

/**
 * Class Filter
 * @package AppBundle\Utils\Manager
 */
class Filter
{
    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @param \AppBundle\Utils\Manager\IFilterQuery $fq
     * @return TableDetails
     * @throws
     */
    public function prepareFilterAndQuery(TableDetails $td, FormsManagerExtended $forms, IFilterQuery $fq)
    {
        $td = $this->prepareDetails($td,$forms);
        $tds = $this->makeFilterAndQuery($td,$forms,$fq);

        if(!$tds instanceof TableDetails){
            throw new \Exception('must be instance of TableDetails'); //todo: custom exception  "$tds must be instance of TableDetails"
        }

        return $tds;
    }

    /**
     * @param TableDetails $tableDetails
     * @param FormsManagerExtended $tmpForms
     * @return TableDetails
     */
    private function prepareDetails(TableDetails $tableDetails, FormsManagerExtended $tmpForms)
    {
        $tableDetails = $this->setFalse($tableDetails, $tmpForms);
        $tableDetails = $this->setFilter($tableDetails, $tmpForms);

        return $tableDetails;
    }

    /**
     * @param TableDetails $tb
     * @param FormsManagerExtended $fms
     * @return TableDetails
     */
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

    /**
     * @param FormsManagerExtended $forms
     * @return bool
     */
    private function isAnyFormValid(FormsManagerExtended $forms)
    {
        return $forms->isAnyFormValid();
    }

    /**
     * @param TableDetails $td
     * @param $forms
     * @return TableDetails
     */
    private function setFilter(TableDetails $td, $forms)
    {
        $filter = $td->getFilter();

        if(!($this->isTableAlreadyFiltered($filter)))
        {
            $td = $this->prepareFilterValue($forms,$td);
        }

        return $td;
    }


    private function isTableAlreadyFiltered($filter)
    {
        if($filter) {
            return true;
        }
        return false;
    }


    /**
     * @param FormsManagerExtended $fms
     * @param TableDetails $td
     * @return TableDetails
     */
    private function prepareFilterValue(FormsManagerExtended $fms, TableDetails $td){
//tu wchodzę gdy tablica nie była teraz filtrowana, ale wcześniej i teraz nowy sort
        if($td->getFilterField()){
            $td->setFilter($td->getFilterField());
            return $td;
        }
        if($fms->isStatusFormValid()){
            $td->setFilter('idstatus');
            $td->setFilterField('idstatus');
            return $td;
        }
        if($fms->isDataZamFormValid()) {
            $td->setFilter('data');
            $td->setFilterField('data');
            return $td;
        }
        if($fms->isNrKlientaFormValid()){
            $td->setFilter('idklient');
            $td->setFilterField('idklient');
            return $td;
        }

        $td->setFilter('all');
        return $td;
    }


    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @param \AppBundle\Utils\Manager\IFilterQuery $fq
     * @return TableDetails
     */
    private function makeFilterAndQuery(TableDetails $td, FormsManagerExtended $forms, IFilterQuery $fq)
    {
        if($td->getFilter() == 'all'){
            return $td;
        }

        if($td->getFilter() == 'idstatus'){
            $tds = $fq->prepareStatusFilterQuery($td, $forms);
            return $tds;
        }

        if($td->getFilter() == 'data') {
            $tds = $fq->prepareDataFilterQuery($td, $forms);
            return $tds;
        }

        if($td->getFilter() == 'idklient'){
            $tds = $fq->prepareKlientFilterQuery($td, $forms);
            return $tds;
        }
    }
}
