<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Zamowienie;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

/**
 *
 */
class ZamowienieRepository extends EntityRepository implements PaginatorAwareInterface
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
     * Łączę entity Zamowienie ze Status by móc w szablonie sortować wg Status.
     * (Muszę tak robić gdyż tradycyjny zapis z.idstatus.status wywala błąd przy próbie sortowania według tegoż).
     *
     * @return Query
     */
    public function queryAll($idklient)
    {
        $query = $this->_em->createQuery('
                SELECT z,s 
                FROM AppBundle:Zamowienie z 
                JOIN z.idstatus s 
                WHERE z.idklient = :idklient 
                ORDER BY z.idzamowienie ASC
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
            case 'datazlozenia':
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
                'SELECT z FROM AppBundle:Zamowienie z ORDER BY z.'.$OrderBy.' '.$sort.''
            )
            ->getResult();
    }


    public function findByXOrderedByY($query,$sortArr,$OrderBy='idzamowienie')
    {
        switch ($OrderBy) {
            case 'datazlozenia':
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
                FROM AppBundle:Zamowienie z 
                WHERE z.'.$query .' 
                ORDER BY z.'.$OrderBy.' '.$sort.''
            )
            ->getResult();
    }
}