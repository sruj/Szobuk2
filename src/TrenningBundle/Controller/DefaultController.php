<?php

namespace TrenningBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * Chapter 3
     * @Route("/3")
     */
    public function chap3Action()
    {
        return $this->render('TrenningBundle:Default:chapter3.html.twig');
    }

    /**
     * Chapter 4
     * Favourite - zmiana stylu paragrafu i guzika po nacisnieciu guzika.
     *
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
     * @Route("/4b", name="c4", options={"expose"=true})
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


    /**
     * Chapter 5
     * Formularz :
                - obliczenie z 3 inputów iloczynu
                - podsiwetlenie inputa jeśli blank
                - gif spin gdy oblicza
                - atrybut disable dla guzika w trakcie wykonywania obliczenia
                (by gościu nie klikał wielokrotnie widząc że nic sie nie dzieje.)
                - drugi guzik gdy ktos nie ma włączone js (tj jeden widoczny)
     * @Route("/5", name="5")
     */
    public function chap5Action(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $form = $request->request->get('form');
            $result = $form['length']*$form['width']*$form['height'];
            return new JsonResponse(array('result' => $result));
        }


        $result=null;
        $form = $this->createFormBuilder()
            ->setMethod('POST')
            ->add('length', NumberType::class)
            ->add('width', NumberType::class)
            ->add('height', NumberType::class)
            ->add('Submit', SubmitType::class)
            ->add('AjaxSubmit', ButtonType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $result=$data['length']*$data['width']*$data['height'];
        }


        return $this->render('TrenningBundle:Default:chapter5.html.twig', array(
            'form' => $form->createView(), 'result'=>$result,
        ));
    }

    /**
     * @Route("/rst1", name="rst1")
     */
    public function rstAction()
    {

        $tablica = [3,5,2,4,6,8,12];

        $w=$this->q($tablica);
        $r=0;

        return $this->render('TrenningBundle:Default:rst1.html.twig');
    }

    private function q($arr){
        foreach($arr as $k => $v) {
            if($v*$v < 26) {
                unset($arr[$k]);
            }
        }
        return $arr;
    }

}
