<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Shipment
 *
 * @ORM\Table(name="przesylka", indexes={@ORM\Index(name="idOrder_idx", columns={"idOrder"})})
 * @ORM\Entity
 */
class Shipment
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
     * @ORM\Column(name="nrShipments", type="string", length=45, nullable=true)
     */
    private $shipmentnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="invoiceNumber", type="string", length=45, nullable=true)
     */
    private $invoicenumber;

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
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Order.php", inversedBy="shipments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOrder", referencedColumnName="idOrder")
     * })
     */
    private $idorder;


    /**
     * Set koszt
     *
     * @param string $koszt
     * @return Shipment
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
     * Set shipmentnumber
     *
     * @param string $shipmentnumber
     * @return Shipment
     */
    public function setShipmentnumber($shipmentnumber)
    {
        $this->shipmentnumber = $shipmentnumber;

        return $this;
    }

    /**
     * Get shipmentnumber
     *
     * @return string 
     */
    public function getShipmentnumber()
    {
        return $this->shipmentnumber;
    }

    /**
     * Set invoicenumber
     *
     * @param string $invoicenumber
     * @return Shipment
     */
    public function setInvoicenumber($invoicenumber)
    {
        $this->invoicenumber = $invoicenumber;

        return $this;
    }

    /**
     * Get invoicenumber
     *
     * @return string 
     */
    public function getInvoicenumber()
    {
        return $this->invoicenumber;
    }

    /**
     * Set datawyslania
     *
     * @param \DateTime $datawyslania
     * @return Shipment
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
     * @return Shipment
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
     * @return int
     */
    public function getIdprzesylka()
    {
        return $this->idprzesylka;
    }

    /**
     * Set idorder
     *
     * @param \AppBundle\Entity\Order $idorder
     * @return Shipment
     */
    public function setIdorder(\AppBundle\Entity\Order $idorder = null)
    {
        $this->idorder = $idorder;

        return $this;
    }

    /**
     * Get idorder
     *
     * @return \AppBundle\Entity\Order
     */
    public function getIdorder()
    {
        return $this->idorder;
    }
}
