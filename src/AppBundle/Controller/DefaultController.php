<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class DefaultController extends Controller {


    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction(Request $request) {
        //jeśli w trakcie zakupów w wyborze autoryzacji wybrałem zaloguj lub zarejestruj to przenoszę się do *gdzieśtam*
        $session = $request->getSession();
        $proces_zamowienia=$session->get('proces_zamowienia');
        if($proces_zamowienia=='tak'){
//            return $this->redirect($this->generateUrl('zamawiam'));
            $session->remove('proces_zamowienia');
            return $this->redirectToRoute('zamawiam');
        };
        
        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:Ksiazka a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            45/*limit per page*/
        );

        return array(
            'pagination' => $pagination,
        );
    }

    
    /**
     * @Route("/popularne", name="popularne")
     * @Template()
     */
    public function popularneAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT k
            FROM AppBundle:Ksiazka k
            WHERE k.cena < :cena
            ORDER BY k.tytul ASC'
        )->setParameter('cena', '50');

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            45/*limit per page*/
        );
        
        $ksiazki = $query->getResult();

        return array(
            'entities' => $pagination,
        );
    }

    
    /**
     * @Route("/nowosci", name="nowosci")
     * @Template()
     */
    public function nowosciAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT k
            FROM AppBundle:Ksiazka k
            ORDER BY k.created DESC'
        );

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            45/*limit per page*/
        );
        
        $ksiazki = $query->getResult();
        
        return array(
            'entities' => $pagination,
        );
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    /**
     * test
     * 
     * KNP paginator
     * 
    * @Route("/knp", name="knp")
    * @Template()
    */
    public function listAction(Request $request)
    {
    $em    = $this->get('doctrine.orm.entity_manager');
    $dql   = "SELECT a FROM AppBundle:Ksiazka a";
    $query = $em->createQuery($dql);

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1)/*page number*/,
        10/*limit per page*/
    );

    // parameters to template
    return $this->render('AppBundle:Default:list.html.twig', array('pagination' => $pagination));
    }
    
    
    
    /**
     * test3
     *
     * @Route("dupa/admin/test3", name="test3")
     * @Template()
     */
    public function test3Action()
    {

        return array();
    }

}
