<?php

namespace TrenningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Chapter 3
     * @Route("/3")
     */
    public function indexAction()
    {
        return $this->render('TrenningBundle:Default:chapter3.html.twig');
    }

    /**
     * Chapter 4
     * @Route("/4")
     */
    public function chap4Action(Request $request)
    {
        $session = $request->getSession();
        
        
        if (!$session->get('fav')){
            $fav=[];
            $fav['p101']='Favorite';
            $fav['p102']='Favorite';
            $fav['p103']='Favorite';
            $session->set('fav',$fav);
        }
        
        return $this->render('TrenningBundle:Default:chapter4.html.twig');
    }


    /**
     * Chapter 4
     * @Route(name="c4", options={"expose"=true})
     */
    public function chap4ReceiveAction(Request $request)
    {
        $session = $request->getSession();

        $f = $request->get('data');
        foreach ($f as $k => $v){
            $fav[substr($k, -4)]=$v;
        }
        $replaced = array_replace($session->get('fav'),$fav);

        $session->set('fav',$replaced );

        return [];
    }
}
