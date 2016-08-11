<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Status
 *
 * @ORM\Table(name="status")
 * @ORM\Entity
 */
class Status
{
    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatus", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idstatus;

    /**
    * @ORM\OneToMany(targetEntity="Zamowienie", mappedBy="idstatus")
    */
    protected $zamowienia;

    
    
//    
//    /**
//     * Set status
//     *
//     * @param string $status
//     * @return Status
//     */
//    public function setStatus($status)
//    {
//        $this->status = $status;
//
//        return $this;
//    }
//
//    /**
//     * Get status
//     *
//     * @return string 
//     */
//    public function getStatus()
//    {
//        return $this->status;
//    }
//
//    /**
//     * Get idstatus
//     *
//     * @return integer 
//     */
//    public function getIdstatus()
//    {
//        return $this->idstatus;
//    }

    /**
     * Set status
     *
     * @param string $status
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get idstatus
     *
     * @return integer 
     */
    public function getIdstatus()
    {
        return $this->idstatus;
    }

        public function __construct() {
        $this->zamowienia = new ArrayCollection();
    } 

    /**
     * Add zamowienia
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienia
     * @return Status
     */
    public function addZamowienium(\AppBundle\Entity\Zamowienie $zamowienia)
    {
        $this->zamowienia[] = $zamowienia;

        return $this;
    }

    /**
     * Remove zamowienia
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienia
     */
    public function removeZamowienium(\AppBundle\Entity\Zamowienie $zamowienia)
    {
        $this->zamowienia->removeElement($zamowienia);
    }

    /**
     * Get zamowienia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZamowienia()
    {
        return $this->zamowienia;
    }
    
        public function __toString()
    {
        return $this->getStatus();
    }
}
