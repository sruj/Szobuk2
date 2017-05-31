<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\DeliveryType;
use AppBundle\Entity\Client;
use AppBundle\Entity\Order;
use AppBundle\Entity\Book;
use AppBundle\Exception\BookNotFoundException;
use AppBundle\Exception\CartNotInSessionException;
use AppBundle\Exception\VariableNotExistInFlashBagException;

class CartController extends Controller
{
    /**
     * Dodaj książkę do koszyka.
     * (zmienna sesji 'cart' przechowuje tablicę produktów $isbn=>$ilość)
     *
     * @Route("/add-to-cart/{isbn}", name="add_to_cart")
     */
    public function addToCartAction(Request $request, $isbn)
    {
        $entity = $this->getDoctrine()->getRepository('Book.php')->find($isbn);

        if (!$entity) {
            throw new BookNotFoundException('Książka z numerem isbn: ' . $isbn . ' nie istnieje w bazie');
        }

        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $cart = $this->getCartFromSessionOrReturnNullIfNotExist($session);

        $cart = $app_cart->addProductToCart($isbn, $cart);
        $session->set('cart', $cart);

        return $this->redirect($this->generateUrl('cart_menu'));
    }

    /**
     * Ilość produktów w koszyku.
     * Akcja używana przez '::layout.html.twig' jako {% render ..cartContent %}
     */
    public function cartContentAction(Request $request)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $cart = $this->getCartFromSessionOrReturnNullIfNotExist($session);
        $cartquantity = $app_cart->getNumberOfProductsInCart($cart);

        return $this->render('AppBundle:Cart:cartcontent.html.twig', ['cartquantity' => $cartquantity]);
    }

    /**
     * Czyszczenie koszyka.
     *
     * @Route("/cart-clear", name="cart_clear")
     */
    public function cartClearAction(Request $request)
    {
        $request->getSession()->invalidate();

        return $this->render('AppBundle:Cart:cart_clear.html.twig', []);
    }

    /**
     * Wybór autoryzacji
     * (zaloguj, zarejestruj, kup bez rejestracji)
     *
     * @Route("/authorization", name="authorization")
     */
    public function authorizationAction()
    {
        return $this->render('AppBundle:Cart:authorization.html.twig', []);
    }

    /**
     * - Jeśli nie jestem zalogowany i będąc w cart_menu klikam "zamawiam" to jestem przekierowany do /authorization a
     *  po wybraniu "zaloguj" lub "zarejestruj" zostaję przeniesiony TU.
     * - TU ustawiam nową zmienną sesji 'orderingProcess', która będzie potrzebna w dalszym etapie by przekierować
     *  w odpowiedni route po zalogowaniu.
     *
     * @Route("/connector/{authorization}", defaults={"authorization" = "zaloguj"}, name="connector")
     */
    public function connectorAction(Request $request, $authorization)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();
        $session->set('orderingProcess', true);                                                                          // zmianna sesji by w dalszym etapie przekierować w odpowiedni route
        $route = $app_cart->prepareRoute($authorization);                                                                     // wybiera nazwę route zaloguj lub rejestruj

        return $this->redirectToRoute($route);
    }

    /**
     * Koszyk.
     * Tu trafiam po dodaniu produktu do koszyka lub po kliknięciu w koszyk.
     * Tu również kierowane jest żądanie gdy wybieram "usuń" chcąc usunąć książkę z koszyka.
     *
     * @Route("/cart/{deleteisbn}", defaults={"deleteisbn" = false}, name="cart_menu")
     */
    public function cartMenuAction(Request $request, $deleteisbn)
    {
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();

        if (!$session->has('cart')) {
            throw new CartNotInSessionException('Koszyk pusty.');
        }

        if ($deleteisbn) {
            $updatedCart = $app_cart->removeProductFromCart($deleteisbn, $session->get('cart'));
            $session->set('cart', $updatedCart);
        }

        $sum = $app_cart->getSumOfAllProductsInCart($session->get('cart'));
        $booksInCartDetails = $app_cart->getAllBooksFromCartDetails($session->get('cart'));

        $session->set('sum', $sum);

        return $this->render('AppBundle:Cart:cart_menu.html.twig', [
            'books' => $booksInCartDetails,
            'suma' => $sum
        ]);
    }

    /**
     * zmiana ilości w cart_menu prowadzi przez skrypt JavaScript tutaj.
     * Na stronie dane zmieniają się automatycznie dzięki skryptowi JS,
     * ale drugim zadaniem skryptu jest te dane przesłać tutaj (bym i ja wiedział a nie tylko przeglądarka i klikający użytkownik)
     * Więc nowe dane trafiają tu, i na ich podstawie aktualizuję zmienne sesji.
     *
     * @Route("/quantity", name="quantity_update", options={"expose"=true})
     */
    public function quantityUpdateAction(Request $request)
    {
        $cart = $request->get('data');                                                                                                          //'data' to z JS tablica z zawartością koszyka
        $app_cart = $this->get('app.cart');
        $session = $request->getSession();

        $session->set('cart', $cart);
        $session->set('sum', $app_cart->getSumOfAllProductsInCart($cart));

        return [];
    }

    /**
     * Formularz danych adresowych klienta.
     * - jeśli poprawnie wypełniono formularz, zamówienie i dane klienta zapisane w bazie.
     * - wystrzeliwany event a listenery robią robotę (wysyłają maile potwierdzające).
     *
     * @Route("/personal-data", name="personal_data")
     */
    public function personalDataAction(Request $request)
    {
        $session = $this->get('session');
        if (!$session->has('cart')) {
            throw new CartNotInSessionException('Koszyk pusty.');
        }

        $client = $this->getDoctrine()
            ->getRepository('Client.php')
            ->findOneBy(['idlogin' => $this->getUser() ? $this->getUser()->getId() : false]);                                                // zalogowany wypełniał kiedyś formularz
        if (!$client) {
            $client = new Client();
        }                                                                                                   // jeśli zalogowany nigdy nie wypełniał formularza dostawy lub jeśli niezalogowany

        $form = $this->createForm(DeliveryType::class, $client, [
            'attr' => ['class' => 'form_dostawa']]);

        $app_form_handler_order = $this->get('app.form_handler.order');
        if ($app_form_handler_order->handleFormAndPlaceOrder($form, $request)) {
            return $this->redirectToRoute('confirm');
        };

        return $this->render('AppBundle:Cart:personal_data.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Potwierdzenie.
     *
     * @Route("/confirm", name="confirm")
     */
    public function confirmAction(Request $request)
    {
        $idorder = $request->getSession()->getFlashBag()->get('idorder');
        if (!$idorder) {
            throw new VariableNotExistInFlashBagException('To jest strona potwierdzająca zamówienie. Aby złożyć zamówienie dodaj produkt do koszyka i tak dalej...');
        }

        $zamowienie = $this->getDoctrine()
            ->getRepository('Order.php')
            ->find($idorder[0]);
        $produkty = $zamowienie->getOrderProducts();
        $suma = $request->getSession()->get('sum');

        return $this->render('AppBundle:Cart:confirm.html.twig', [
            'zamowienie' => $zamowienie, 'produkty' => $produkty,
            'suma' => $suma
        ]);
    }

    /**
     * @param $session
     * @return null
     */
    private function getCartFromSessionOrReturnNullIfNotExist($session)
    {
        $cart = null;

        if ($session->has('cart')) {
            $cart = $session->get('cart');
        }
        return $cart;
    }

}
