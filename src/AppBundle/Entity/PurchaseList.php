<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class PurchaseList
{
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getPurchases()
    {
        return $this->orders;
    }
}