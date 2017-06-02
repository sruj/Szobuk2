<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-14
 * Time: 20:19
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Purchase;


class PurchasePlacedEvent extends Event
{
    const NAME = 'purchase.placed';

    protected $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    public function getPurchase()
    {
        return $this->purchase;
    }

}