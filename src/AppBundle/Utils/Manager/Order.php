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
use AppBundle\Exception\PurchaseNotFoundException;

class Purchase
{
    private $em;
    private $tableDetails;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return TableDetails
     */
    public function getTableDetails()
    {
        return $this->tableDetails;
    }

    public function preparePurchase(TableDetails $td_f)
    {
        if ($td_f->getQuery()) {
            return $this->preparePurchaseRepositoryForFilterSelected($td_f);
        }

        if (!$td_f->getQuery()) {
            return $this->preparePurchaseRepositoryUnfiltered($td_f);
        }
    }

    private function preparePurchaseRepositoryForFilterSelected(TableDetails $td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Purchase')
            ->findByXPurchasedByY(
                $td->getQuery(),
                $td->getColumnsSortPurchase(),
                $td->getColumnSort());
        if (!$repo) {
            throw new PurchaseNotFoundException('Nie można znaleźć zamówień');
        }

        return $repo;
    }

    private function preparePurchaseRepositoryUnfiltered(TableDetails $td)
    {
        $this->tableDetails = $td;
        $repo = $this->em->getRepository('AppBundle:Purchase')
            ->findAllPurchasedByY(
                $td->getColumnsSortPurchase(),
                $td->getColumnSort());
        if (!$repo) {
            throw new PurchaseNotFoundException('Nie można znaleźć zamówień');
        }

        return $repo;
    }

}
