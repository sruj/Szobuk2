<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-12
 * Time: 15:44
 */

namespace AppBundle\Utils\Manager;


class TableDetails
{
    private $columnsSortOrder;
    private $columnSort;
    private $filterField;
    private $query;
    private $filter;
    private $identifier;
    
    
    
    
    /**
     * @return mixed
     */
    public function getColumnsSortOrder()
    {
        return $this->columnsSortOrder;
    }

    /**
     * @param mixed $columnsSortOrder
     */
    public function setColumnsSortOrder($columnsSortOrder)
    {
        $this->columnsSortOrder = $columnsSortOrder;
    }

    /**
     * @return mixed
     */
    public function getColumnSort()
    {
        return $this->columnSort;
    }

    /**
     * @param mixed $columnSort
     */
    public function setColumnSort($columnSort)
    {
        $this->columnSort = $columnSort;
    }

    /**
     * @return mixed
     */
    public function getFilterField()
    {
        return $this->filterField;
    }

    /**
     * @param mixed $filterField
     */
    public function setFilterField($filterField)
    {
        $this->filterField = $filterField;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @param mixed $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

}