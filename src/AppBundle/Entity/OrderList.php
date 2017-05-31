<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


class OrderList
{

    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getOrders()
    {
        return $this->orders;
    }


}