<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-12-04
 * Time: 13:51
 */

namespace AppBundle\Utils\Manager;

class Sort
{
    private $columnsSortOrder;
    private $column;

    function __construct(TableDetails $tableConfigDetails)
    {
        $this->columnsSortOrder = $tableConfigDetails->getColumnsSortPurchase();
        $this->column = $tableConfigDetails->getColumnSort();

        $this->prepareColumnsSortPurchase();
    }

    private function prepareColumnsSortPurchase()
    {
        if (!($this->columnsSortOrder)) {
            $this->setAllNullNumerASC();
        } else {
            $this->setSortVar();
            $this->AscDescChanger();
        }
    }

    /**
     * [-Sortowanie-]Jeśli pierwszy raz otwieram stronę to tworzę tablicę $sortArr
     * i każdy element ustawiam na DESC
     */
    private function setAllNullNumerASC()
    {
        $this->columnsSortOrder = [
            'Status' => 'null',
            'Klient' => 'null',
            'Numer' => 'ASC',
            'Data' => 'null',
        ];
    }

    /**
     * [-Sortowanie-]zmiana każdej sortownicy na przeciwną (w kolejnej funkcji zależnie od wartości
     * klikniętej zmiennej click te zmienne się zmienią.
     */
    private function setSortVar()
    {
        if ($this->columnsSortOrder == 'ASC') {
            $temp = 'DESC';
        } else {
            $temp = 'ASC';
        }
        $this->columnsSortOrder = $temp;
    }

    /**
     * [-Sortowanie-]W zależności od wartości zmiennej $PurchaseBy ustawia elementy tablicy
     * $sortArr na 'null' poza elementem tablicy tożsamym z $PurchaseBy.
     * Czyli jeśli $PurchaseBy=='orderdate' to ustawi $sortArr['Data']
     */
    private function AscDescChanger()
    {
        switch ($this->column) {
            case "orderdate":
                $this->columnsSortOrder = ['Status' => 'null', 'Klient' => 'null', 'Numer' => 'null',
                    'Data' => $this->columnsSortOrder];
                break;
            case "idclient":
                $this->columnsSortOrder = ['Status' => 'null', 'Data' => 'null', 'Numer' => 'null',
                    'Klient' => $this->columnsSortOrder];
                break;
            case "idstatus":
                $this->columnsSortOrder = ['Data' => 'null', 'Klient' => 'null', 'Numer' => 'null',
                    'Status' => $this->columnsSortOrder];
                break;
            case "idorder":
                $this->columnsSortOrder = ['Status' => 'null', 'Klient' => 'null', 'Data' => 'null',
                    'Numer' => $this->columnsSortOrder];
                break;
            default:
                $this->columnsSortOrder = ['Status' => 'null', 'Klient' => 'null', 'Data' => 'null',
                    'Numer' => 'ASC'];
        }
    }

    /**
     * @return array
     */
    public function getColumnsSortPurchase()
    {
        return $this->columnsSortOrder;
    }

}