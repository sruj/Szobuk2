<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Order;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

/**
 *
 */
class OrderRepository extends EntityRepository implements PaginatorAwareInterface
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
     * Łączę entity Order ze Status by móc w szablonie sortować wg Status.
     * (Muszę tak robić gdyż tradycyjny zapis z.idstatus.status wywala błąd przy próbie sortowania według tegoż).
     *
     * @return Query
     */
    public function queryAll($idklient)
    {
        $query = $this->_em->createQuery('
                SELECT z,s 
                FROM AppBundle:Order z 
                JOIN z.idstatus s 
                WHERE z.idklient = :idklient 
                ORDER BY z.idorder ASC
            ');

        $query = $query->setParameter('idklient', $idklient);

        return $query;
    }

    public function findAllMy($page, $idklient)
    {
        return $this->paginator->paginate(
            $this->queryAll($idklient),
            $page/*page number*/,
            91/*limit per page*/
        );
    }


    public function findAllOrderedByY($sortArr,$OrderBy)
    {
        switch ($OrderBy) {
            case 'orderdate':
                $sort=$sortArr['Data'];
                break;
            case 'idklient':
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
                'SELECT z FROM AppBundle:Order z ORDER BY z.'.$OrderBy.' '.$sort.''
            )
            ->getResult();
    }


    public function findByXOrderedByY($query,$sortArr,$OrderBy='idorder')
    {
        switch ($OrderBy) {
            case 'orderdate':
                $sort=$sortArr['Data'];
                break;
            case 'idklient':
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
                FROM AppBundle:Order z 
                WHERE z.'.$query .' 
                ORDER BY z.'.$OrderBy.' '.$sort.''
            )
            ->getResult();
    }
}