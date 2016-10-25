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
    
    public function queryWyszukiwarka($word)
    {
        $repository = $this->em->getRepository('AppBundle:Ksiazka');
        return $query = $repository->createQueryBuilder('a')
            ->where('a.tytul LIKE :word')
            ->orWhere('a.autor LIKE :word')
            ->orWhere('a.wydawnictwo LIKE :word')
            ->setParameter('word', '%' . $word . '%')
            ->getQuery();
    }

    /**
     * @return Query
     */
    public function queryByWhat($findby, $what)
    {
        return $this->em->createQuery(
            'SELECT a
            FROM AppBundle:Ksiazka a
            WHERE a.'.$findby.' = :param'
        )->setParameter('param', $what);            
    }    
    
    /**
     * @param int $page
     */
    public function findAllMy($page, $limit = Ksiazka::NUM_ITEMS)
    {
        return $this->paginator->paginate(
            $this->queryAll(),
            $page/*page number*/,
            $limit/*limit per page*/
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
            Ksiazka::NUM_ITEMS/*limit per page*/
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
            Ksiazka::NUM_ITEMS/*limit per page*/
        );
    }
    
    public function findWyszukiwarka($word, $page)
    {
        return $this->paginator->paginate(
            $this->queryWyszukiwarka($word),
            $page/*page number*/,
            Ksiazka::NUM_ITEMS/*limit per page*/
        );
    }   
    
    public function findByWhat($findby, $what, $page)
    {
        return $this->paginator->paginate(
            $this->queryByWhat($findby, $what),
            $page/*page number*/,
            Ksiazka::NUM_ITEMS/*limit per page*/
        );
    }


}