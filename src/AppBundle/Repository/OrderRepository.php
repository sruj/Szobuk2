<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Purchase;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

/**
 *
 */
class PurchaseRepository extends EntityRepository implements PaginatorAwareInterface
{
    /**
     * @var
     */
    protected $paginator;

    
    /**
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }


    /**
     * Łączę entity Purchase ze Status by móc w szablonie sortować wg Status.
     * (Muszę tak robić gdyż tradycyjny zapis z.idstatus.status wywala błąd przy próbie sortowania według tegoż).
     *
     * @return Query
     */
    public function queryAll($idclient)
    {
        $query = $this->_em->createQuery('
                SELECT z,s 
                FROM AppBundle:Purchase z 
                JOIN z.idstatus s 
                WHERE z.idclient = :idclient 
                ORDER BY z.idorder ASC
            ');

        $query = $query->setParameter('idclient', $idclient);

        return $query;
    }

    public function findAllMy($page, $idclient)
    {
        return $this->paginator->paginate(
            $this->queryAll($idclient),
            $page/*page number*/,
            91/*limit per page*/
        );
    }


    public function findAllPurchasedByY($sortArr,$PurchaseBy)
    {
        switch ($PurchaseBy) {
            case 'orderdate':
                $sort=$sortArr['Data'];
                break;
            case 'idclient':
                $sort=$sortArr['Klient'];
                break;
            case 'idstatus':
                $sort=$sortArr['Status'];
                break;
            default:
                $sort=$sortArr['Numer'];
        }

        return $this->_em
            ->createQuery(
                'SELECT z FROM AppBundle:Purchase z ORDER BY z.'.$PurchaseBy.' '.$sort.''
            )
            ->getResult();
    }


    public function findByXPurchasedByY($query,$sortArr,$PurchaseBy='idorder')
    {
        switch ($PurchaseBy) {
            case 'orderdate':
                $sort=$sortArr['Data'];
                break;
            case 'idclient':
                $sort=$sortArr['Klient'];
                break;
            case 'idstatus':
                $sort=$sortArr['Status'];
                break;
            default:
                $sort=$sortArr['Numer'];
        }

        return $this->_em
            ->createQuery(
                'SELECT z 
                FROM AppBundle:Purchase z 
                WHERE z.'.$query .' 
                ORDER BY z.'.$PurchaseBy.' '.$sort.''
            )
            ->getResult();
    }
}