<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Przesylka
 *
 * @ORM\Table(name="przesylka", indexes={@ORM\Index(name="idZamowienie_idx", columns={"idZamowienie"})})
 * @ORM\Entity
 */
class Przesylka
{
    /**
     * @var string
     *
     * @ORM\Column(name="koszt", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $koszt;

    /**
     * @var string
     *
     * @ORM\Column(name="nrPrzesylki", type="string", length=45, nullable=true)
     */
    private $nrprzesylki;

    /**
     * @var string
     *
     * @ORM\Column(name="nrFaktury", type="string", length=45, nullable=true)
     */
    private $nrfaktury;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataWyslania", type="date", nullable=true)
     */
    private $datawyslania;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonDostawcy", type="string", length=45, nullable=true)
     */
    private $telefondostawcy;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPrzesylka", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprzesylka;


    /**
     * @var \AppBundle\Entity\Zamowienie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zamowienie", inversedBy="przesylki")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idZamowienie", referencedColumnName="idZamowienie")
     * })
     */
    private $idzamowienie;


    /**
     * Set koszt
     *
     * @param string $koszt
     * @return Przesylka
     */
    public function setKoszt($koszt)
    {
        $this->koszt = $koszt;

        return $this;
    }

    /**
     * Get koszt
     *
     * @return string 
     */
    public function getKoszt()
    {
        return $this->koszt;
    }

    /**
     * Set nrprzesylki
     *
     * @param string $nrprzesylki
     * @return Przesylka
     */
    public function setNrprzesylki($nrprzesylki)
    {
        $this->nrprzesylki = $nrprzesylki;

        return $this;
    }

    /**
     * Get nrprzesylki
     *
     * @return string 
     */
    public function getNrprzesylki()
    {
        return $this->nrprzesylki;
    }

    /**
     * Set nrfaktury
     *
     * @param string $nrfaktury
     * @return Przesylka
     */
    public function setNrfaktury($nrfaktury)
    {
        $this->nrfaktury = $nrfaktury;

        return $this;
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
     * Set datawyslania
     *
     * @param \DateTime $datawyslania
     * @return Przesylka
     */
    public function setDatawyslania($datawyslania)
    {
        $this->datawyslania = $datawyslania;

        return $this;
    }

    /**
     * Get datawyslania
     *
     * @return \DateTime 
     */
    public function getDatawyslania()
    {
        return $this->datawyslania;
    }

    /**
     * Set telefondostawcy
     *
     * @param string $telefondostawcy
     * @return Przesylka
     */
    public function setTelefondostawcy($telefondostawcy)
    {
        $this->telefondostawcy = $telefondostawcy;

        return $this;
    }

    /**
     * Get telefondostawcy
     *
     * @return string 
     */
    public function getTelefondostawcy()
    {
        return $this->telefondostawcy;
    }

    /**
     * Get idprzesylka
     *
     * @return integer 
     */
    public function getIdprzesylka()
    {
        return $this->idprzesylka;
    }

    /**
     * Set idzamowienie
     *
     * @param \AppBundle\Entity\Zamowienie $idzamowienie
     * @return Przesylka
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
