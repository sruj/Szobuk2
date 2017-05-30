<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Order
 *
 * @ORM\Table(name="zamowienie", indexes={@ORM\Index(name="idKlient_idx", columns={"idKlient"}), @ORM\Index(name="idStatus_idx", columns={"idStatus"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZamowienieRepository")
*/
class Order
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataZlozenia", type="datetime", nullable=true)
     */
    private $datazlozenia;

    /**
     * @var integer
     *
     * @ORM\Column(name="idZamowienie", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idzamowienie;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="Client.php", inversedBy="zamowienia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idKlient", referencedColumnName="idKlient")
     * })
     */
    private $idklient;



    /**
     * @var \AppBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status", inversedBy="zamowienia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idStatus", referencedColumnName="idStatus")
     * })
     */
    private $idstatus;

    
    
    
    /**
    * @ORM\OneToMany(targetEntity="Invoice.php", mappedBy="idzamowienie")
    */
    protected $faktury;



    /**
    * @ORM\OneToMany(targetEntity="Shipment.php", mappedBy="idzamowienie")
    */
    protected $przesylki;



    /**
    * @ORM\OneToMany(targetEntity="ZamowienieProdukt", mappedBy="idzamowienie")
    */
    protected $zamowienie_produkty;



    /**
     * Set datazlozeniacurrent
     * Ustawienie aktualnej daty-godziny.
     * wystarczy na rzecz instancji zamówienia odpalić te funkcję
     * i w bazie danych  dodana bedzie aktualna data zakupu
     *  $zamowienie = new Order();
     *  $zamowienie->setDatazlozeniacurrent();
     * 
     */
    public function setDatazlozeniacurrent()
    {

        $this->datazlozenia = new DateTime();

        return $this;
    }
    
    
    /**
     * Set datazlozenia
     *
     * @param \DateTime $datazlozenia
     * @return Order
     */
    public function setDatazlozenia($datazlozenia)
    {
        $this->datazlozenia = $datazlozenia;

        return $this;
    }

    /**
     * Get datazlozenia
     *
     * @return \DateTime 
     */
    public function getDatazlozenia()
    {
        return $this->datazlozenia;
    }

    /**
     * Get idzamowienie
     *
     * @return int
     */
    public function getIdzamowienie()
    {
        return $this->idzamowienie;
    }

    /**
     * Set idstatus
     *
     * @param \AppBundle\Entity\Status $idstatus
     * @return Order
     */
    public function setIdstatus(\AppBundle\Entity\Status $idstatus = null)
    {
        $this->idstatus = $idstatus;

        return $this;
    }

    /**
     * Get idstatus
     *
     * @return \AppBundle\Entity\Status 
     */
    public function getIdstatus()
    {
        return $this->idstatus;
    }

    /**
     * Set idklient
     *
     * @param \AppBundle\Entity\Client $idklient
     * @return Order
     */
    public function setIdklient(\AppBundle\Entity\Client $idklient = null)
    {
        $this->idklient = $idklient;

        return $this;
    }

    /**
     * Get idklient
     *
     * @return \AppBundle\Entity\Client
     */
    public function getIdklient()
    {
        return $this->idklient;
    }

    public function __construct() {
        $this->faktury = new ArrayCollection();
        $this->zamowienie_produkty = new ArrayCollection();
    }

    /**
     * Add faktury
     *
     * @param \AppBundle\Entity\Invoice $faktury
     * @return Order
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

    /**
     * Get faktury
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFaktury()
    {
        return $this->faktury;
    }

    /**
     * Add przesylki
     *
     * @param \AppBundle\Entity\Shipment $przesylki
     * @return Order
     */
    public function addPrzesylki(\AppBundle\Entity\Shipment $przesylki)
    {
        $this->przesylki[] = $przesylki;

        return $this;
    }

    /**
     * Remove przesylki
     *
     * @param \AppBundle\Entity\Shipment $przesylki
     */
    public function removePrzesylki(\AppBundle\Entity\Shipment $przesylki)
    {
        $this->przesylki->removeElement($przesylki);
    }

    /**
     * Get przesylki
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrzesylki()
    {
        return $this->przesylki;
    }

    /**
     * Add zamowienie_produkty
     *
     * @param \AppBundle\Entity\OrderProduct $zamowienieProdukty
     * @return Order
     */
    public function addZamowienieProdukt(\AppBundle\Entity\OrderProduct $zamowienieProdukt)
    {
        if(!$this->zamowienie_produkty->contains($zamowienieProdukt)) {
            $this->zamowienie_produkty[] = $zamowienieProdukt;
        }

        return $this;
    }

    /**
     * Remove zamowienie_produkty
     *
     * @param \AppBundle\Entity\OrderProduct $zamowienieProdukty
     */
    public function removeZamowienieProdukty(\AppBundle\Entity\OrderProduct $zamowienieProdukt)
    {
        $this->zamowienie_produkty->removeElement($zamowienieProdukt);
    }

    /**
     * Get zamowienie_produkty
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZamowienieProdukty()
    {
        return $this->zamowienie_produkty;
    }
}
