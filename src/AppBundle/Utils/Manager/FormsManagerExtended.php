<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-13
 * Time: 12:39
 */

namespace AppBundle\Utils\Manager;

use AppBundle\Utils\Manager\FormsManager;
use AppBundle\Exception\NoValidDataInFormException;

class FormsManagerExtended extends FormsManager
{
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
        $idstatus = $this->forms['StatusForm']->get('status')->getData()->getIdstatus();
        if(isset($idstatus)){
            return $idstatus;
        }
        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getOdFromDataZamForm()
    {
        $od = $this->forms['DataZamForm']->get('od')->getData()->format('Y-m-d H:i:s');
        if(isset($od)){
            return $od;
        }
        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getDoFromDataZamForm()
    {
        $do = $this->forms['DataZamForm']->get('do')->getData()->format('Y-m-d H:i:s');
        if(isset($do)){
            return $do;
        }
        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getIdKlientFromNrKlientaForm()
    {
        $idklient = $this->forms['NrKlientaForm']->get('idklient')->getData()->getIdklient();
        if(isset($idklient)){
            return $idklient;
        }
        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

}