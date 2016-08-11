<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


class ZamowienieList
{

    private $zamowienia;

    public function __construct()
    {
        $this->zamowienia = new ArrayCollection();
    }

    public function getZamowienia()
    {
        return $this->zamowienia;
    }


}