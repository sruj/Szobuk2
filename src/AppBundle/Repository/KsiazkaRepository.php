<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ksiazka;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

/**
 *
 */
class KsiazkaRepository extends EntityRepository implements PaginatorAwareInterface
{
    /**
     * @var
     */
    protected $paginator;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * KsiazkaRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @return Query
     */
    public function queryAll()
    {
        return $this->em->createQuery('
                SELECT a 
                FROM AppBundle:Ksiazka a
            ');
    }

    /**
     * @return Query
     */
    public function queryPopularne()
    {
        return $this->em->createQuery('
            SELECT k
            FROM AppBundle:Ksiazka k
            WHERE k.cena < :cena
            ORDER BY k.tytul ASC'
        )->setParameter('cena', '50');
    }
    
    /**
     * @return Query
     */
    public function queryNowosci()
    {
        return $this->em->createQuery('
            SELECT k
            FROM AppBundle:Ksiazka k
            ORDER BY k.created DESC'
        );
    }

    /**
     * @param int $page
     */
    public function findAllMy($page)
    {
        return $this->paginator->paginate(
            $this->queryAll(),
            $page/*page number*/,
            45/*limit per page*/
        );
    }

    /**
     * @param int $page
     */
    public function findPopularne($page)
    {
        return $this->paginator->paginate(
            $this->queryPopularne(),
            $page/*page number*/,
            45/*limit per page*/
        );
    }
    
    /**
     * @param int $page
     */
    public function findNowosci($page)
    {
        return $this->paginator->paginate(
            $this->queryNowosci(),
            $page/*page number*/,
            45/*limit per page*/
        );
    }


}