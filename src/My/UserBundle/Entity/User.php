<?php

namespace My\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    protected $klient;
    
    public function getKlient()
    {
        return $this->klient;
    }

    public function setKlient(\AppBundle\Entity\Klient $klient  = null)
    {
        $this->klient = $klient;
    }
    
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    
    
    

}
