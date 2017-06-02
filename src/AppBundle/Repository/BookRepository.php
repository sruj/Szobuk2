<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Book;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;
use Knp\Component\Pager\Paginator;

class BookRepository extends EntityRepository implements PaginatorAwareInterface
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
                FROM AppBundle:Book a
                WHERE a.quantity>0
                ORDER BY a.title ASC
            ');
    }

    /**
     * @return Query
     */
    public function queryAllAdmin()
    {
        return $this->_em->createQuery('
                SELECT a 
                FROM AppBundle:Book a
                ORDER BY a.title ASC
            ');
    }

    /**
     * @return Query
     */
    public function queryPopular()
    {
        return $this->_em->createQuery('
            SELECT k
            FROM AppBundle:Book k
            WHERE k.price < :price AND k.quantity>0
            ORDER BY k.title ASC'
        )->setParameter('price', '50');
    }

    /**
     * @return Query
     */
    public function queryNews()
    {
        return $this->_em->createQuery('
            SELECT k
            FROM AppBundle:Book k
            WHERE k.quantity>0
            ORDER BY k.created DESC'
        );
    }

    public function queryWyszukiwarka($word)
    {
        $repository = $this->_em->getRepository('AppBundle:Book');

        return $query = $repository->createQueryBuilder('a')
            ->where('a.title LIKE :word')
            ->orWhere('a.author LIKE :word')
            ->orWhere('a.print LIKE :word')
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
            FROM AppBundle:Book a
            WHERE a.' . $findby . ' = :param'
        )->setParameter('param', $what);

    }

    /**
     * @param int $page
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function findAllMy($page, $limit = Book::NUM_ITEMS)
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
    public function findAllAdmin($page, $limit = Book::NUM_ITEMS)
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
            Book::NUM_ITEMS/*limit per page*/
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
            Book::NUM_ITEMS/*limit per page*/
        );
    }

    public function findWyszukiwarka($word, $page)
    {
        return $this->paginator->paginate(
            $this->queryWyszukiwarka($word),
            $page/*page number*/,
            Book::NUM_ITEMS/*limit per page*/
        );
    }

    public function findByWhat($findby, $what, $page)
    {
        return $this->paginator->paginate(
            $this->queryByWhat($findby, $what),
            $page/*page number*/,
            Book::NUM_ITEMS/*limit per page*/
        );
    }


}