<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Merchant
 *
 * @ORM\Table(name="dane_sprzedawcy")
 * @ORM\Entity
 */
class Merchant
{
    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=45, nullable=true)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=45, nullable=true)
     */
    private $ulica;

    /**
     * @var string
     *
     * @ORM\Column(name="nrDomu", type="string", length=45, nullable=true)
     */
    private $nrdomu;

    /**
     * @var string
     *
     * @ORM\Column(name="nrMieszkania", type="string", length=45, nullable=true)
     */
    private $nrmieszkania;

    /**
     * @var string
     *
     * @ORM\Column(name="kodPocztowy", type="string", length=45, nullable=true)
     */
    private $kodpocztowy;

    /**
     * @var string
     *
     * @ORM\Column(name="miasto", type="string", length=45, nullable=true)
     */
    private $miasto;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=45, nullable=true)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="nrTelefonu", type="string", length=45, nullable=true)
     */
    private $nrtelefonu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idSprzedawca", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsprzedawca;

    /**
    * @ORM\OneToMany(targetEntity="Faktura", mappedBy="idsprzedawca")
    */
    protected $faktury;

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return Merchant
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     * @return Merchant
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;

        return $this;
    }

    /**
     * Get ulica
     *
     * @return string 
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * Set nrdomu
     *
     * @param string $nrdomu
     * @return Merchant
     */
    public function setNrdomu($nrdomu)
    {
        $this->nrdomu = $nrdomu;

        return $this;
    }

    /**
     * Get nrdomu
     *
     * @return string 
     */
    public function getNrdomu()
    {
        return $this->nrdomu;
    }

    /**
     * Set nrmieszkania
     *
     * @param string $nrmieszkania
     * @return Merchant
     */
    public function setNrmieszkania($nrmieszkania)
    {
        $this->nrmieszkania = $nrmieszkania;

        return $this;
    }

    /**
     * Get nrmieszkania
     *
     * @return string 
     */
    public function getNrmieszkania()
    {
        return $this->nrmieszkania;
    }

    /**
     * Set kodpocztowy
     *
     * @param string $kodpocztowy
     * @return Merchant
     */
    public function setKodpocztowy($kodpocztowy)
    {
        $this->kodpocztowy = $kodpocztowy;

        return $this;
    }

    /**
     * Get kodpocztowy
     *
     * @return string 
     */
    public function getKodpocztowy()
    {
        return $this->kodpocztowy;
    }

    /**
     * Set miasto
     *
     * @param string $miasto
     * @return Merchant
     */
    public function setMiasto($miasto)
    {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto
     *
     * @return string 
     */
    public function getMiasto()
    {
        return $this->miasto;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Merchant
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set nrtelefonu
     *
     * @param string $nrtelefonu
     * @return Merchant
     */
    public function setNrtelefonu($nrtelefonu)
    {
        $this->nrtelefonu = $nrtelefonu;

        return $this;
    }

    /**
     * Get nrtelefonu
     *
     * @return string 
     */
    public function getNrtelefonu()
    {
        return $this->nrtelefonu;
    }

    /**
     * Get idsprzedawca
     *
     * @return int
     */
    public function getIdsprzedawca()
    {
        return $this->idsprzedawca;
    }
    
    public function __construct() {
        $this->faktury = new ArrayCollection();
    }    
    
    /**
     * Get faktury
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getFaktury() {
        return $this->faktury;
    }

    /**
     * Add faktury
     *
     * @param \AppBundle\Entity\Invoice $faktury
     * @return Merchant
     */
    public function addFaktury(\AppBundle\Entity\Invoice $faktury)
    {
        $this->faktury[] = $faktury;

        return $this;
    }

    /**
     * Remove faktury
     *
     * @param \AppBundle\Entity\Invoice $faktury
     */
    public function removeFaktury(\AppBundle\Entity\Invoice $faktury)
    {
        $this->faktury->removeElement($faktury);
    }
}
