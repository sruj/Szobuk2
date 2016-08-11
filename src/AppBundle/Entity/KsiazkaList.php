<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


class KsiazkaList
{

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