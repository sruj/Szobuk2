<?php
/**
 * Created by PhpStorm.
 * User: chiny
 * Date: 2016-10-26
 * Time: 22:40
 */


namespace AppBundle\Tests\Utils;
use Symfony\Component\DomCrawler\Crawler;


/**
 * - Klasa do sprawdzania czy wiersze kolumny posortowane alfabetycznie w testach funkcjonalnych
 * - Wywołując isAlphabetic() podaję XPath pokrojony w dwóch kawałkach w zmiennych $front i $back
 *  oraz $crawler
 * 
 * Class ColumnSortChecker
 * @package AppBundle\Tests\Utils
 */
class ColumnSortChecker
{
    /**
     * Zwraca tablicę stringów z zawartością 5 kolejnych wierszy kolumny
     * 
     * @param $front string
     * @param $back string
     * @param $crawler Crawler
     * @return array
     */
    private function prepareStringArray($front, $back, $crawler)
    {
        $array = $this->prepareXPathArray($front, $back);
        foreach ($array as $item) {
            $w[]= $crawler->filterXPath($item)->text();
        }
        return $w;

    }

    /**
     * Skleja Xpath 5 kolejnych wierszy kolumny
     * Zwraca tablicę np  
     *  0 => //tbody/tr['0']/td[1]/a'
     *  1 => //tbody/tr['1']/td[1]/a'
     *  2 => //tbody/tr['2']/td[1]/a'
     *  3 => //tbody/tr['3']/td[1]/a'
     *  4 => //tbody/tr['4']/td[1]/a'
     * 
     * @param $front string
     * @param $back string
     * @return array
     */
    private function prepareXPathArray($front, $back){
        for ($i=0; $i<5; $i++){
            $arr[$i]=$front.($i+1).$back;
        }
        return $arr;
    }

    /**
     * Z pomocą dwóch metod sprawdza tablicę stringów z zawartością 5 kolejnych wierszy kolumny czy jest posortowana alfabetycznie
     * Jeśli alfabetycznie to zwraca true.
     * 
     * @param $front string np. //tbody/tr['
     * @param $back string  np. ']/td[1]/a' - cyfra oznacza nr kolumny sortującej 
     * @param $crawler Crawler
     * @return bool
     */
    public function isAlphabetic($front, $back, $crawler)
    {
        $array = $this->prepareStringArray($front, $back, $crawler);

        for ($i = 0; $i < 4; $i++ ){
            if (strcasecmp($array[$i], $array[$i+1]) > 0){
                return false; //niealfabetyczne
            };
        }
        return true;//alfabetyczne
    }

}