<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shipment
 *
 * @ORM\Table(name="shipment", indexes={@ORM\Index(name="idOrder_idx", columns={"idOrder"})})
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
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order", inversedBy="shipments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOrder", referencedColumnName="idOrder")
     * })
     */
    private $idorder;

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
