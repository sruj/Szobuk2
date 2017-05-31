<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-14
 * Time: 20:19
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Order;


class OrderPlacedEvent extends Event
{
    const NAME = 'order.placed';

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getZamowienie()
    {
        return $this->order;
    }

}