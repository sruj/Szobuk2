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
    public function prepareStatusFilterQuery($td, $forms)
    {
        if((!$td['query']) and (!$td['identifier'])) {
            $td['identifier'] = $forms['StatusForm']->get('status')->getData()->getIdstatus();
        }

        if((!$td['query']) and ($td['identifier'])) {
            $td['query'] = 'idstatus = ' . $td['identifier'];
        }

        return $td;
    }

    public function prepareDataFilterQuery($td, $forms)
    {
        if($td['query']) {
            $td['query'] = urldecode($td['query']);
        }

        if (!$td['query']) {
            $od = $forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
            $do = $forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
            $td['query'] = "datazlozenia BETWEEN '" . $od . "' AND '" . $do . "'";
        }

        $td['query'] = urlencode($td['query']);

        return $td;
    }

    public function prepareKlientFilterQuery($td, $forms)
    {
        if ((!($td['query'])) and (!$td['identifier'])) {
            $td['identifier'] = $forms['NrKlientaForm']->get('idklient')->getData()->getIdklient();
            $td['query'] = 'idklient = ' . $td['identifier'];
            return $td;
        }

        if ((!($td['query'])) and $td['identifier']) {
            $td['query'] = 'idklient = ' . $td['identifier'];
            return $td;
        }

        return $td;
    }    

}