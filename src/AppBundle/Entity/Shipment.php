<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shipment
 *
 * @ORM\Table(name="shipment", indexes={@ORM\Index(name="idPurchase_idx", columns={"idPurchase"})})
 * @ORM\Entity
 */
class Shipment
{
    /**
     * @var string
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cost;

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
     * @ORM\Column(name="shipmentDate", type="date", nullable=true)
     */
    private $shipmentdate;

    /**
     * @var string
     *
     * @ORM\Column(name="delivererPhone", type="string", length=45, nullable=true)
     */
    private $delivererphone;

    /**
     * @var integer
     *
     * @ORM\Column(name="idShipment", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idshipment;


    /**
     * @var \AppBundle\Entity\Purchase
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="shipments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPurchase", referencedColumnName="idPurchase")
     * })
     */
    private $idpurchase;

    /**
     * Set cost
     *
     * @param string $cost
     * @return Shipment
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
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
     * Set shipmentdate
     *
     * @param \DateTime $shipmentdate
     * @return Shipment
     */
    public function setShipmentdate($shipmentdate)
    {
        $this->shipmentdate = $shipmentdate;

        return $this;
    }

    /**
     * Get shipmentdate
     *
     * @return \DateTime
     */
    public function getShipmentdate()
    {
        return $this->shipmentdate;
    }

    /**
     * Set delivererphone
     *
     * @param string $delivererphone
     * @return Shipment
     */
    public function setDelivererphone($delivererphone)
    {
        $this->delivererphone = $delivererphone;

        return $this;
    }

    /**
     * Get delivererphone
     *
     * @return string
     */
    public function getDelivererphone()
    {
        return $this->delivererphone;
    }

    /**
     * Get idshipment
     *
     * @return int
     */
    public function getIdshipment()
    {
        return $this->idshipment;
    }

    /**
     * Set idpurchase
     *
     * @param \AppBundle\Entity\Purchase $idpurchase
     * @return Shipment
     */
    public function setIdpurchase(\AppBundle\Entity\Purchase $idpurchase = null)
    {
        $this->idpurchase = $idpurchase;

        return $this;
    }

    /**
     * Get idpurchase
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getIdpurchase()
    {
        return $this->idpurchase;
    }
}
