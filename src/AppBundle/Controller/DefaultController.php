<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Ksiazka;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller
{
    /**
     * Kontroler przygotowujący dane do wyświetlenia książek używane na stronie głównej (wszystkie, nowości, popularne)
     *
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        //REFAKTOR: poniżej to jakieś paskództwo, albo to przenieśc albo coś z tym zrobić

        //jeśli w trakcie zakupów w wyborze autoryzacji wybrałem zaloguj lub zarejestruj to przenoszę się do *gdzieśtam*
        $session = $request->getSession();
        $proces_zamowienia=$session->get('proces_zamowienia');
        if($proces_zamowienia == 'tak'){
            $session->remove('proces_zamowienia');
            return $this->redirectToRoute('zamawiam');
        };
        
        $ksi_rep = $this->get('app.ksiazka_repository');
        $ksiazki = $ksi_rep->findAllMy($request->query->getInt('page', 1));

        return ['ksiazki' => $ksiazki];
    }

    
    /**
     * @Route("/popularne", name="popularne")
     * @Template()
     */
    public function popularneAction(Request $request)
    {
        $ksi_rep = $this->get('app.ksiazka_repository');
        $ksiazki = $ksi_rep->findPopularne($request->query->getInt('page', 1));

        return ['ksiazki' => $ksiazki];
    }

    
    /**
     * @Route("/nowosci", name="nowosci")
     * @Template()
     */
    public function nowosciAction(Request $request)
    {
        $ksi_rep = $this->get('app.ksiazka_repository');
        $ksiazki = $ksi_rep->findAllMy($request->query->getInt('page', 1));

        return ['ksiazki' => $ksiazki];
    }
}
