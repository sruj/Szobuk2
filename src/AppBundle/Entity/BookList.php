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

    private $ksiazki;

    public function __construct()
    {
        $this->ksiazki = new ArrayCollection();
    }

    public function getKsiazki()
    {
        return $this->ksiazki;
    }


}