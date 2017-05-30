<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-09
 * Time: 00:01
 */

namespace AppBundle\Utils\Cart;

use AppBundle\Entity\Book;
use Doctrine\ORM\EntityManager;
use AppBundle\Exception\ProductNotInCartException;

class Cart
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function addProductToCart($isbn, $cart)
    {
        if (!($this->isCartInSession($cart))) {
            $c[$isbn] = 1;

            return $c;
        }

        if (!($this->isProductInCart($isbn, $cart))) {
            $cart[$isbn] = 1;

            return $cart;
        }

        if ($this->isProductInCart($isbn, $cart)) {
            $cart[$isbn]++;

            return $cart;
        }
    }

    public function removeProductFromCart($isbn, $cart)
    {
        if ($this->isProductInCart($isbn, $cart)) {
            unset($cart[$isbn]);

            return $cart;
        }

        throw new ProductNotInCartException('Nie można usunąć produktu z koszyka. Nie ma 
        książki o ISBN: ' . $isbn . ' w koszyku');
    }

    public function getNumberOfProductsInCart($cart)
    {
        $cartQuantity = 0;
        if (!empty($cart)) {
            $cartQuantity = array_sum($cart);
        }
        
        return $cartQuantity;
    }

    /**
     * return 'fos_user_security_login'
     */
    public function prepareRoute($authorization)
    {
        switch ($authorization) {
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
        $books = null;

        foreach ($cart as $isbn => $quantity) {
            /** @var Book $book */
            $book = $this->em->getRepository('AppBundle:Book')->find($isbn);
            $books[$i]['isbn'] = $book->getIsbn();
            $books[$i]['tytul'] = $book->getTitle();
            $books[$i]['author'] = $book->getAuthor();
            $books[$i]['cena'] = $book->getPrice();
            $books[$i]['quantity'] = $quantity;
            $i++;
        }

        return $books;
    }

    public function getSumOfAllProductsInCart($cart)
    {
        $sum = 0;

        foreach ($cart as $isbn => $quantity) {
            /** @var Book $book */
            $book = $this->em->getRepository('AppBundle:Book')->find($isbn);
            $price = (int)$book->getPrice();
            $together = $price * $quantity;
            $sum += $together;
        }

        return $sum;
    }
}