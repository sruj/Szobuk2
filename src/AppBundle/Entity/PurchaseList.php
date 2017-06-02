<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class PurchaseList
{
    private $purchases;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    public function getPurchases()
    {
        return $this->purchases;
    }
}