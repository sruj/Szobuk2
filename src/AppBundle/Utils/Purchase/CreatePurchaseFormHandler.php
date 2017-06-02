<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:29
 */

namespace AppBundle\Utils\Purchase;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Exception\CartNotInSessionException;

class CreatePurchaseFormHandler
{
    private $purchaseManager;

    /**
     * CreatePurchaseFormHandler constructor.
     */
    public function __construct(PurchaseManager $purchaseManager)
    {
        $this->purchaseManager = $purchaseManager;
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function handleFormAndPlacePurchase(FormInterface $form, Request $request)
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
        $this->purchaseManager->placePurchase($deliveryClientData, $cart);

        return true;
    }

}