<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager; 

/**
 * Nie używane. zaczałęm ale zrezygnowałem
 *
 * @author chin
 */
class ZarzadcaUtil {
    
    public $em;
    public $Nsort;
    public $Dsort;
    public $Ksort;
    public $Ssort;

    
    
    /**
     * __construct
     * ustawia zmienne 
     * 
     */  
    public function __construct( EntityManager $em )
    {
        $this->em= $em;
    }
           
    
    /**
    * @param 
    * @return 
    */          
    public function getKsiazka($isbn)
    {
        $k=$this->em->getRepository('AppBundle:Ksiazka')
        ->find($isbn);

        return $k;
    }
    
    /**
    * @param 
    * @return 
    */          
    public function setSortVar($var)
    {
        if ($var=='ASC'){
            $var='DESC';
        }else{
            $var='ASC';
        }
    
        return $var;
    }
       
     
}