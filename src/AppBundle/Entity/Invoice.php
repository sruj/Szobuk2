<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Invoice - nieużywane
 *
 * @ORM\Table(name="faktura", indexes={@ORM\Index(name="idZamowienie_idx", columns={"idZamowienie"}), @ORM\Index(name="idSprzedawcy_idx", columns={"idSprzedawca"})})
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataFaktury", type="date", nullable=true)
     */
    private $datafaktury;

    /**
     * @var string
     *
     * @ORM\Column(name="nrFaktury", type="string", length=45)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nrfaktury;


    /**
     * @var \AppBundle\Entity\Merchant
     *
     * @ORM\ManyToOne(targetEntity="Merchant.php", inversedBy="faktury")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSprzedawca", referencedColumnName="idSprzedawca")
     * })
     */
    private $idsprzedawca;



    /**
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Order.php", inversedBy="faktury")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idZamowienie", referencedColumnName="idZamowienie")
     * })
     */
    private $idzamowienie;

    




    /**
     * Set datafaktury
     *
     * @param \DateTime $datafaktury
     * @return Invoice
     */
    public function setDatafaktury($datafaktury)
    {
        $this->datafaktury = $datafaktury;

        return $this;
    }

    /**
     * Get datafaktury
     *
     * @return \DateTime 
     */
    public function getDatafaktury()
    {
        return $this->datafaktury;
    }

    /**
     * Get nrfaktury
     *
     * @return string 
     */
    public function getNrfaktury()
    {
        return $this->nrfaktury;
    }

    /**
     * Set idsprzedawca
     *
     * @param \AppBundle\Entity\Merchant $idsprzedawca
     * @return Invoice
     */
    public function setIdsprzedawca(\AppBundle\Entity\Merchant $idsprzedawca = null)
    {
        $this->idsprzedawca = $idsprzedawca;

        return $this;
    }

    /**
     * Get idsprzedawca
     *
     * @return \AppBundle\Entity\Merchant
     */
    public function getIdsprzedawca()
    {
        return $this->idsprzedawca;
    }

    /**
     * Set idzamowienie
     *
     * @param \AppBundle\Entity\Order $idzamowienie
     * @return Invoice
     */
    public function setIdzamowienie(\AppBundle\Entity\Order $idzamowienie = null)
    {
        $this->idzamowienie = $idzamowienie;

        return $this;
    }

    /**
     * Get idzamowienie
     *
     * @return \AppBundle\Entity\Order
     */
    public function getIdzamowienie()
    {
        return $this->idzamowienie;
    }
}
