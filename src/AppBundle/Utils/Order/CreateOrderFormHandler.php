<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:29
 */

namespace AppBundle\Utils\Order;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateOrderFormHandler
{
    private $orderManager;

    /**
     * CreateZamowienieFormHandler constructor.
     */
    public function __construct(OrderManager $orderManager)
    {
        $this->orderManager = $orderManager;
    }

    public function handleFormAndPlaceOrder(FormInterface $form, Request $request )
    {
        $form->handleRequest($request);
        if (!$form->isValid()) {return false;}
        $cart = $request->getSession()->get('cart');
        $deliveryClientData = $form->getData();
        $this->orderManager->placeOrder($deliveryClientData, $cart);
        return true;
    }
    
}