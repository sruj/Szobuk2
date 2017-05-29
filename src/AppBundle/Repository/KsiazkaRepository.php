<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ksiazka;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

class KsiazkaRepository extends EntityRepository implements PaginatorAwareInterface
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @param Paginator $paginator
     * @return mixed|void
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
        return $this->_em->createQuery('
                SELECT a 
                FROM AppBundle:Ksiazka a
                WHERE a.ilosc>0
                ORDER BY a.tytul ASC
            ');
    }

    /**
     * @return Query
     */
    public function queryAllAdmin()
    {
        return $this->_em->createQuery('
                SELECT a 
                FROM AppBundle:Ksiazka a
                ORDER BY a.tytul ASC
            ');
    }

    /**
     * @return Query
     */
    public function queryPopular()
    {
        return $this->_em->createQuery('
            SELECT k
            FROM AppBundle:Ksiazka k
            WHERE k.cena < :cena AND k.ilosc>0
            ORDER BY k.tytul ASC'
        )->setParameter('cena', '50');
    }

    /**
     * @return Query
     */
    public function queryNews()
    {
        return $this->_em->createQuery('
            SELECT k
            FROM AppBundle:Ksiazka k
            WHERE k.ilosc>0
            ORDER BY k.created DESC'
        );
    }

    public function queryWyszukiwarka($word)
    {
        $repository = $this->_em->getRepository('AppBundle:Ksiazka');

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
        return $this->_em->createQuery(
            'SELECT a
            FROM AppBundle:Ksiazka a
            WHERE a.' . $findby . ' = :param'
        )->setParameter('param', $what);

    }

    /**
     * @param int $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
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
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findAllAdmin($page, $limit = Ksiazka::NUM_ITEMS)
    {
        return $this->paginator->paginate(
            $this->queryAllAdmin(),
            $page/*page number*/,
            $limit/*limit per page*/
        );
    }

    /**
     * @param int $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findPopular($page)
    {
        return $this->paginator->paginate(
            $this->queryPopular(),
            $page/*page number*/,
            Ksiazka::NUM_ITEMS/*limit per page*/
        );
    }

    /**
     * @param int $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findNews($page)
    {
        return $this->paginator->paginate(
            $this->queryNews(),
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