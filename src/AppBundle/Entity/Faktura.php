<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Faktura - nieużywane
 *
 * @ORM\Table(name="faktura", indexes={@ORM\Index(name="idZamowienie_idx", columns={"idZamowienie"}), @ORM\Index(name="idSprzedawcy_idx", columns={"idSprzedawca"})})
 * @ORM\Entity
 */
class Faktura
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
     * @var \AppBundle\Entity\DaneSprzedawcy
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DaneSprzedawcy", inversedBy="faktury")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSprzedawca", referencedColumnName="idSprzedawca")
     * })
     */
    private $idsprzedawca;



    /**
     * @var \AppBundle\Entity\Zamowienie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zamowienie", inversedBy="faktury")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idZamowienie", referencedColumnName="idZamowienie")
     * })
     */
    private $idzamowienie;

    




    /**
     * Set datafaktury
     *
     * @param \DateTime $datafaktury
     * @return Faktura
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
     * @param \AppBundle\Entity\DaneSprzedawcy $idsprzedawca
     * @return Faktura
     */
    public function setIdsprzedawca(\AppBundle\Entity\DaneSprzedawcy $idsprzedawca = null)
    {
        $this->idsprzedawca = $idsprzedawca;

        return $this;
    }

    /**
     * Get idsprzedawca
     *
     * @return \AppBundle\Entity\DaneSprzedawcy 
     */
    public function getIdsprzedawca()
    {
        return $this->idsprzedawca;
    }

    /**
     * Set idzamowienie
     *
     * @param \AppBundle\Entity\Zamowienie $idzamowienie
     * @return Faktura
     */
    public function setIdzamowienie(\AppBundle\Entity\Zamowienie $idzamowienie = null)
    {
        $this->idzamowienie = $idzamowienie;

        return $this;
    }

    /**
     * Get idzamowienie
     *
     * @return \AppBundle\Entity\Zamowienie 
     */
    public function getIdzamowienie()
    {
        return $this->idzamowienie;
    }
}
