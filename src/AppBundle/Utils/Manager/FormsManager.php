<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-13
 * Time: 11:58
 */

namespace AppBundle\Utils\Manager;


class FormsManager
{

    /**
     * @var \Symfony\Component\Form\FormInterface[] $forms
     */
    protected $forms;

    /**
     * FormsManager constructor.
     */
    public function __construct(array $forms)
    {
        $this->forms = $forms;
    }

    public function isAnyFormValid()
    {
        foreach ($this->forms as $form){
            if($form->isValid()){
                return true;
            };
        }
        return false;
    }
}
