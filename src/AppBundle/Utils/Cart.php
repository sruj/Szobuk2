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
     * @return bool
     */
    public function addProductToCart($isbn)
    {
        if (!($this->session->has('cart')))//jeśli zmienna sesji cart nie istnieje to:
        {
            return $this->addOne($isbn);
        }

        $cart = $this->session->get('cart');
        
        if (!array_key_exists($isbn, $cart))//jeśli isbn nie jest w koszu
        {
            return $this->addOne($isbn, $cart); // = 1
        } 
        
        $cart[$isbn]++;
        $this->session->set('cart', $cart);
        if($cart == $this->session->get('cart')){
            return true;
        }
        return false;
    }

    
    /**
     * @param $isbn
     * @param $cart
     * @return bool
     */
    protected function addOne($isbn, $cart = false)
    {
        $cart[$isbn] = 1;
        $this->session->set('cart', $cart);

        if($cart == $this->session->get('cart')){
            return true;
        }
        return false;
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
        return $this->session->invalidate();
    }
    
}