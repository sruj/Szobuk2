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
        $this->columnsSortOrder = $tableConfigDetails->getColumnSort();
        $this->column = $tableConfigDetails->getColumnSort();

        $this->prepareColumnsSortOrder();
    }


    private function prepareColumnsSortOrder()
    {
        if (!($this->columnsSortOrder)) {
            $this->setAllNullNumerASC();
        } else {
            $this->setSortVar();
            $this->AscDescChanger();
        }
        
    }



    //[-Sortowanie-]Jeśli pierwszy raz otwieram stronę to tworzę tablicę $sortArr
    //i każdy element ustawiam na DESC
    private function setAllNullNumerASC(){
        $this->columnsSortOrder = [
            'Data'=>'null',
            'Klient'=>'null',
            'Numer'=>'ASC',
            'Status'=>'null'
        ];
    }

    
    //[-Sortowanie-]zmiana każdej sortownicy na przeciwną (w kolejnej funkcji zależnie od wartości
    //klikniętej zmiennej click te zmienne się zmienią.
    private function setSortVar(){
        if ($this->columnsSortOrder == 'ASC'){
            $temp = 'DESC';
        }else{
            $temp ='ASC';
        }
        $this->columnsSortOrder = $temp;
    }

    
    //[-Sortowanie-]W zależności od wartości zmiennej $OrderBy ustawia elementy tablicy
    //$sortArr na 'null' poza elementem tablicy tożsamym z $OrderBy.
    //Czyli jeśli $OrderBy=='datazlozenia' to ustawi $sortArr['Data']
    private function AscDescChanger(){
        switch ($this->column) {
            case "datazlozenia":
                $this->columnsSortOrder = ['Status'=>'null','Klient'=>'null','Numer'=>'null',
                    'Data'=>$this->columnsSortOrder];
                break;
            case "idklient":
                $this->columnsSortOrder = ['Status'=>'null','Data'=>'null','Numer'=>'null',
                    'Klient'=>$this->columnsSortOrder];
                break;
            case "idstatus":
                $this->columnsSortOrder = ['Data'=>'null','Klient'=>'null','Numer'=>'null',
                    'Status'=>$this->columnsSortOrder];
                break;
            case "idzamowienie":
                $this->columnsSortOrder = ['Status'=>'null','Klient'=>'null','Data'=>'null',
                    'Numer'=>$this->columnsSortOrder];
                break;
            default:
                $this->columnsSortOrder = ['Status'=>'null','Klient'=>'null','Data'=>'null',
                    'Numer'=>'ASC'];
        }
    }

    
    /**
     * @return array
     */
    public function getColumnsSortOrder()
    {
        return $this->columnsSortOrder;
    }

}