<?php

namespace AppBundle\Utils;
use Symfony\Component\HttpFoundation\Request;

class Cart {
    
    public $request;
    public $session;
    public $cart;

    public function __construct()
    {
        $this->request = new Request();
        $this->session = $this->request->getSession();
        $this->cart = $this->session->get('cart');
    }
}
        $cart_obiekt = new Cart();

//2
namespace AppBundle\Utils;


class Cart {
    
    public $request;
    public $session;
    public $cart;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->session = $this->request->getSession();
        $this->cart = $this->session->get('cart');
    }
}
    
        $cart_obiekt = new Cart($request);