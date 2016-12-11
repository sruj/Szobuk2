<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-04
 * Time: 21:25
 */

namespace AppBundle\Utils\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Utils\Manager\Filter;



class Order
{
    private $em;
    private $tableDetails;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getTableDetails()
    {
        return $this->tableDetails;
    }

    public function prepareOrder($td_f)
    {
        if($td_f['query']){
            return $this->prepareOrderRepositoryForFilterSelected($td_f);
        }
        
        if(!$td_f['query']) {
            return $this->prepareOrderRepositoryUnfiltered($td_f);
        }
    }
    
    private function prepareOrderRepositoryUnfiltered($td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Zamowienie')
            ->findAllOrderedByY(
                $td['columnsSortOrder'],
                $td['columnSort']);
        if (!$repo) {throw new \Exception('Nie można znaleźć zamówień');}

        return $repo;
    }

    private function prepareOrderRepositoryForFilterSelected($td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Zamowienie')
            ->findByXOrderedByY(
                $td['query'],
                $td['columnsSortOrder'],
                $td['columnSort']);
        if (!$repo) {throw new \Exception('Nie można znaleźć zamówień');}

        return $repo;
    }


}
