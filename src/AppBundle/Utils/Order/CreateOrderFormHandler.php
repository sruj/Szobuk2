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
use AppBundle\Exception\CartNotInSessionException;

class CreateOrderFormHandler
{
    private $orderManager;

    /**
     * CreateOrderFormHandler constructor.
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
    public function handleFormAndPlaceOrder(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }

        if (!$request->getSession()->has('cart')) {
            throw new CartNotInSessionException('Koszyk pusty.');
        }

        $cart = $request->getSession()->get('cart');
        $deliveryClientData = $form->getData();
        $this->orderManager->placeOrder($deliveryClientData, $cart);

        return true;
    }

}