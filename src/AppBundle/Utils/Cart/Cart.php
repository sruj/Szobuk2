<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-09
 * Time: 00:01
 */

namespace AppBundle\Utils\Cart;

use Doctrine\ORM\EntityManager;

class Cart
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em= $em;
    }



    public function addProductToCart($isbn, $cart)
    {
        if (!($this->isCartInSession($cart)))
        {
            $c[$isbn] = 1;
            return $c;
        }

        if (!($this->isProductInCart($isbn,$cart)))
        {
            $cart[$isbn] = 1;
            return $cart;
        }

        if ($this->isProductInCart($isbn,$cart))
        {
            $cart[$isbn]++;
            return $cart;
        }
    }


    public function removeProductFromCart($isbn, $cart)
    {
        if($this->isProductInCart($isbn,$cart))
        {
            unset($cart[$isbn]);
            return $cart;
        }
        throw new \Exception('Nie można usunąć produktu z koszyka. Nie ma 
        książki o ISBN: '.$isbn.' w koszyku');
    }
    

    public function getNumerOfProductsInCart($cart)
    {
        $cartquantity = 0;
        if(!empty($cart))
        {
            $cartquantity = array_sum($cart);
        }
        return $cartquantity;
    }


    /**
     * return 'fos_user_security_login'
     */
    public function prepareRoute($autoryzacja)
    {
        switch ($autoryzacja){
            case 'zaloguj':
                return 'fos_user_security_login';
                break;
            case 'zarejestruj':
                return 'fos_user_registration_register';
                break;
        }
    }


    private function isCartInSession($cart)
    {
        return !empty($cart);
    }


    private function isProductInCart($isbn, $cart)
    {
        return array_key_exists($isbn, $cart);
    }


    public function getAllBooksFromCartDetails($cart)
    {
        $i = 0;
        $ksiazki = null;

        foreach ($cart as $isbn => $quantity)
        {
            $ksiazka = $this->em->getRepository('AppBundle:Ksiazka')->find($isbn);
            $ksiazki[$i]['isbn'] = $ksiazka->getIsbn();
            $ksiazki[$i]['tytul'] = $ksiazka->getTytul();
            $ksiazki[$i]['autor'] = $ksiazka->getAutor();
            $ksiazki[$i]['cena'] = $ksiazka->getCena();
            $ksiazki[$i]['quantity'] = $quantity;
            $i++;
        }

        return $ksiazki;
    }


    public function getSumOfAllProductsInCart($cart)
    {
        $sum = 0;

        foreach ($cart as $isbn => $quantity)
        {
            $ksiazka = $this->em->getRepository('AppBundle:Ksiazka')->find($isbn);
            $cena = (int)$ksiazka->getCena();
            $razem = $cena*$quantity;
            $sum += $razem;
        }

        return $sum;
    }
}