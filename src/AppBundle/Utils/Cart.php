<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-09
 * Time: 00:01
 */

namespace AppBundle\Utils;

use Symfony\Component\HttpFoundation\Session\Session;

class Cart
{
    private $session;

    /**
     * Cart constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    /**
     * @param $isbn
     */
    public function addProductToCart($isbn)
    {
        if (!($this->session->has('cart')))//jeśli zmienna sesji cart nie istnieje to:
        {
            $this->addOne($isbn);
            return;
        }

        $cart = $this->session->get('cart');
        
        if (!array_key_exists($isbn, $cart))//jeśli isbn nie jest w koszu
        {
            $this->addOne($isbn, $cart); // = 1
            return;
        } 
        
        $cart[$isbn]++;
        $this->session->set('cart', $cart);
    }

    public function getCartQuantity()
    {
        $cartquantity = 0;

        if($this->session->has('cart'))//jeśli zmienna sesji cart juz jest to:
        {
            $cart = $this->session->get('cart');
            $cartquantity = array_sum($cart)  ;
        }
        
        return $cartquantity;

    }

    public function sessionInvalidate()
    {
        $this->session->invalidate();
    }
    
    /**
     * @param $isbn
     * @param $cart
     */
    protected function addOne($isbn, $cart = false)
    {
        $cart[$isbn] = 1;
        $this->session->set('cart', $cart);
    }
}