<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-13
 * Time: 12:39
 */

namespace AppBundle\Utils\Manager;

use AppBundle\Utils\Manager\FormsManager;

class FormsManagerExtended extends FormsManager
{
    //todo: tu wszędzie powrzucać throw exeption jeśli nie halo.

    //refaktor:to do extends tej klasy wrzucić bo zbyt specyficzne
    public function isStatusFormValid()
    {
        return $this->forms['StatusForm']->isValid();
    }

    public function isDataZamFormValid()
    {
        return $this->forms['DataZamForm']->isValid();
    }

    public function isNrKlientaFormValid()
    {
        return $this->forms['NrKlientaForm']->isValid();
    }

    public function getIdStatusFromStatusForm()
    {
        return $this->forms['StatusForm']->get('status')->getData()->getIdstatus();
    }

    public function getOdFromDataZamForm()
    {
        return $this->forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
    }

    public function getDoFromDataZamForm()
    {
        return $this->forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
    }

    public function getIdKlientFromNrKlientaForm()
    {
        return $this->forms['NrKlientaForm']->get('idklient')->getData()->getIdklient();
    }






}