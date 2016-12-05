<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-13
 * Time: 23:29
 */

namespace AppBundle\Utils;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateZamowienieFormHandler
{
    private $zamowienieManager;



    /**
     * CreateZamowienieFormHandler constructor.
     */
    public function __construct(ZamowienieManager $zamowienieManager)
    {
        $this->zamowienieManager = $zamowienieManager;
    }

    public function handle(FormInterface $form, Request $request )
    {
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }

        $klient = $form->getData();

        $this->zamowienieManager->tworzZamowienie($klient);

          return true;

    }
}