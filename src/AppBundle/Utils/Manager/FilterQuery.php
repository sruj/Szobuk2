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
    public function prepareStatusFilterQuery(TableDetails $td, $forms)
    {
        if((!$td->getQuery()) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms['StatusForm']->get('status')->getData()->getIdstatus());
        }

        if((!$td->getQuery()) and ($td->getIdentifier())) {
            $td->setQuery('idstatus = ' . $td->getIdentifier());
        }

        return $td;
    }

    public function prepareDataFilterQuery(TableDetails $td, $forms)
    {
        if($td->getQuery()) {
            $td->setQuery(urldecode($td->getQuery()));
        }

        if (!$td->getQuery()) {
            $od = $forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
            $do = $forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
            $td->setQuery("datazlozenia BETWEEN '" . $od . "' AND '" . $do . "'");
        }

        return $td;
    }

    public function prepareKlientFilterQuery(TableDetails $td, $forms)
    {
        if ((!($td->getQuery())) and (!$td->getIdentifier())) {
            $td->setIdentifier($forms['NrKlientaForm']->get('idklient')->getData()->getIdklient());
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