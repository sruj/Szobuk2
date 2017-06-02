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

    public function isPurchaseDateFormValid()
    {
        return $this->forms['PurchaseDateForm']->isValid();
    }

    public function isClientNumberFormValid()
    {
        return $this->forms['ClientNumberForm']->isValid();
    }

    public function getIdStatusFromStatusForm()
    {
        $idstatus = $this->forms['StatusForm']->get('status')->getData()->getIdstatus();
        if (isset($idstatus)) {
            return $idstatus;
        }

        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getFromFromPurchaseDateForm()
    {
        $from = $this->forms['PurchaseDateForm']->get('od')->getData()->format('Y-m-d H:i:s');
        if (isset($from)) {
            return $from;
        }

        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getToFromPurchaseDateForm()
    {
        $to = $this->forms['PurchaseDateForm']->get('do')->getData()->format('Y-m-d H:i:s');
        if (isset($to)) {
            return $to;
        }

        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

    public function getIdClientFromClientNumberForm()
    {
        $idclient = $this->forms['ClientNumberForm']->get('idclient')->getData()->getIdclient();
        if (isset($idclient)) {
            return $idclient;
        }

        throw new NoValidDataInFormException('Nie można odczytać danych z formularza');
    }

}