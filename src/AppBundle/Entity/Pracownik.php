<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pracownik - nieużywane
 *
 * @ORM\Table(name="pracownik", indexes={@ORM\Index(name="idLogowanie_idx", columns={"idLogowanie"})})
 * @ORM\Entity
 */
class Pracownik
{
    /**
     * @var string
     *
     * @ORM\Column(name="imie", type="string", length=45, nullable=false)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=45, nullable=false)
     */
    private $nazwisko;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=45, nullable=false)
     */
    private $ulica;

    /**
     * @var string
     *
     * @ORM\Column(name="nrDomu", type="string", length=45, nullable=false)
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
     * @ORM\Column(name="miasto", type="string", length=45, nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="stanowisko", type="string", length=45, nullable=false)
     */
    private $stanowisko;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPracownik", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpracownik;

    /**
     * @var \My\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="My\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlogowanie", referencedColumnName="id")
     * })
     */
    private $idlogowanie;



    /**
     * Set imie
     *
     * @param string $imie
     * @return Pracownik
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Pracownik
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Pracownik
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * @return Pracownik
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
     * Set stanowisko
     *
     * @param string $stanowisko
     * @return Pracownik
     */
    public function setStanowisko($stanowisko)
    {
        $this->stanowisko = $stanowisko;

        return $this;
    }

    /**
     * Get stanowisko
     *
     * @return string 
     */
    public function getStanowisko()
    {
        return $this->stanowisko;
    }

    /**
     * Get idpracownik
     *
     * @return integer 
     */
    public function getIdpracownik()
    {
        return $this->idpracownik;
    }

    /**
     * Set idlogowanie
     *
     * @param \My\UserBundle\Entity\User $id
     * @return Klient
     */
    public function setIdlogowanie(\My\UserBundle\Entity\User $id = null)
    {
        $this->idlogowanie = $id;

        return $this;
    }

    /**
     * Get idlogowanie
     *
     * @return \My\UserBundle\Entity\User
     */
    public function getIdlogowanie()
    {
        return $this->idlogowanie;
    }
    
    public function __construct() {
        $this->zamowienia = new ArrayCollection();
    }  

}
