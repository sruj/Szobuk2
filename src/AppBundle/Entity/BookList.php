<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


class BookList
{
    /**
     * liczba książek na stronie (katalog: /book/)
     */
    const NUM_ITEMS = 45;

    private $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getBooks()
    {
        return $this->books;
    }


}