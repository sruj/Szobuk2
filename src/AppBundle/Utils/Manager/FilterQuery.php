<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-11
 * Time: 15:18
 */

namespace AppBundle\Utils\Manager;


class FilterQuery implements IFilterQuery
{
    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @return TableDetails
     */
    public function prepareStatusFilterQuery(TableDetails $td, FormsManagerExtended $forms)
    {
        if((!$td->getQuery()) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms->getIdStatusFromStatusForm());
        }

        if((!$td->getQuery()) and ($td->getIdentifier())) {
            $td->setQuery('idstatus = ' . $td->getIdentifier());
        }

        return $td;
    }

    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @return TableDetails
     */
    public function prepareDataFilterQuery(TableDetails $td, FormsManagerExtended $forms)
    {
        if($td->getQuery()) {
            $td->setQuery(urldecode($td->getQuery()));
        }

        if (!$td->getQuery()) {
            $od = $forms->getOdFromDataZamForm();
            $do = $forms->getDoFromDataZamForm();
            $td->setQuery("datazlozenia BETWEEN '" . $od . "' AND '" . $do . "'");
        }

        return $td;
    }

    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @return TableDetails
     */
    public function prepareKlientFilterQuery(TableDetails $td, FormsManagerExtended $forms)
    {
        if ((!($td->getQuery())) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms->getIdKlientFromNrKlientaForm());
            $td->setQuery('idklient = ' . $td->getIdentifier());
            return $td;
        }

        if ((!($td->getQuery())) and $td->getIdentifier()) {
            $td->setQuery('idklient = ' . $td->getIdentifier());
            return $td;
        }

        return $td;
    }
}