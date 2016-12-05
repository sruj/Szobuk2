<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-14
 * Time: 20:19
 */

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use AppBundle\Entity\Zamowienie;


class OrderPlacedEvent extends Event
{
    const NAME = 'order.placed';

    protected $zamowienie;

    public function __construct(Zamowienie $zamowienie)
    {
        $this->zamowienie = $zamowienie;
    }

    public function getZamowienie()
    {
        return $this->zamowienie;
    }

}