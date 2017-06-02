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
        if ((!$td->getQuery()) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms->getIdStatusFromStatusForm());
            $td->setQuery('idstatus = ' . $td->getIdentifier());

            return $td;
        }

        if ((!$td->getQuery()) and ($td->getIdentifier())) {
            $td->setQuery('idstatus = ' . $td->getIdentifier());

            return $td;
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
        if ($td->getQuery()) {
            $td->setQuery(urldecode($td->getQuery()));

            return $td;
        }

        if (!$td->getQuery()) {
            $from = $forms->getFromFromPurchaseDateForm();
            $to = $forms->getToFromPurchaseDateForm();
            $td->setQuery("purchasedate BETWEEN '" . $from . "' AND '" . $to . "'");

            return $td;
        }
    }

    /**
     * @param TableDetails $td
     * @param FormsManagerExtended $forms
     * @return TableDetails
     */
    public function prepareClientFilterQuery(TableDetails $td, FormsManagerExtended $forms)
    {
        if ((!($td->getQuery())) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms->getIdClientFromClientNumberForm());
            $td->setQuery('idclient = ' . $td->getIdentifier());

            return $td;
        }

        if ((!($td->getQuery())) and $td->getIdentifier()) {
            $td->setQuery('idclient = ' . $td->getIdentifier());

            return $td;
        }

        return $td;
    }
}