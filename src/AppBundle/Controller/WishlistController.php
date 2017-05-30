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

//TODO: do roboty
class WishlistController extends Controller
{
    
    /**
     * Adding product to wishlist.
     *
     *
     * @Route("/addtowishlist", name="addtowishlist", options={"expose"=true})
     */
    public function addtowishlistAction(Request $request)
    {
    //wsl 2. odbierz zmienną z ajax isbn
        $isbn = $request->get('data');


    //wsl 3. odbierz obiekt usera aktualnie zalogowane
        $user =  $this->getUser();      //albo $this->getUser()->getId()

    //wsl 4. zapisz w bazie danych w tabeli wishlist produkt z isbn z ajax
        // COŚ Z UŻYCIEM PONIŻSZEGO NIECO.
            //        $this->getDoctrine()
            //            ->getRepository('AppBundle:Client')
            //            ->findOneBy(['idlogowanie' => $this->getUser() ? $this->getUser()->getId() : false]);


        return [];
    }



     /**
     * Showing wishlist page.
     *
     *
     * @Route("/wishlist", name="showwishlist" )
     */
    public function showwishlistAction(Request $request)
    {
        //wsl 5. odbierz z db produkty z wishlist
        //wsl 6. wyświetl w template
    }
}
