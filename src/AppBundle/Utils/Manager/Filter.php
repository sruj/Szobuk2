<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-10
 * Time: 23:41
 */

namespace AppBundle\Utils\Manager;


class Filter
{

    public function prepareStatusFilter($td, $forms)
    {
        if((!$td['query']) and (!$td['identifier'])) {
            $td['identifier'] = $forms['StatusForm']->get('status')->getData()->getIdstatus();
        }

        if((!$td['query']) and ($td['identifier'])) {
            $td['query'] = 'idstatus = ' . $td['identifier'];
        }

        $td['filterField'] = 'idstatus';

        return $td;
    }

    public function prepareDataFilter($td, $forms)
    {
        if($td['query']) {
            $td['query'] = urldecode($td['query']);
        }

        if (!$td['query']) {
            $od = $forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
            $do = $forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
            $td['query'] = "datazlozenia BETWEEN '" . $od . "' AND '" . $do . "'";
        }

        $td['filterField'] = 'data';
        $td['query'] = urlencode($td['query']);

        return $td;
    }

    public function prepareKlientFilter($td, $forms)
    {
        if ((!($td['query'])) and (!$td['identifier'])) {
            $td['identifier'] = $forms['NrKlientaForm']->get('idklient')->getData()->getIdklient();
            return $td;
        }

        if ((!($td['query'])) and $td['identifier']) {
            $td['query'] = 'idklient = ' . $td['identifier'];
            return $td;
        }

        return $td;
    }
    
    
    
    
    
    
    

}