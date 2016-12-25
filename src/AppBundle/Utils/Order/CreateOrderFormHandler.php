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


    /**
     * @param FormInterface $form
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function handleFormAndPlaceOrder(FormInterface $form, Request $request )
    {
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return false;
        }
        $cart = $request->getSession()->get('cart');
        if (empty($cart)){
            throw new \Exception('koszyk pusty');
        }
        $deliveryClientData = $form->getData();
        $res = $this->orderManager->placeOrder($deliveryClientData, $cart);
        if (empty($res)){
            throw new \Exception('Nie udało się złożyć zamówienia. Weź że się zastanów co ty w ogóle robisz.');
        }
        return true;
    }
    
}