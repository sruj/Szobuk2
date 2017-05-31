<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Order
 *
 * @ORM\Table(name="order", indexes={@ORM\Index(name="idClient_idx", columns={"idClient"}), @ORM\Index(name="idStatus_idx", columns={"idStatus"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orderDate", type="datetime", nullable=true)
     */
    private $orderdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="idOrder", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idorder;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", inversedBy="orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     * })
     */
    private $idclient;

    /**
     * @var \AppBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status", inversedBy="orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idStatus", referencedColumnName="idStatus")
     * })
     */
    private $idstatus;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice", mappedBy="idorder")
     */
    protected $invoices;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Shipment", mappedBy="idorder")
     */
    protected $shipments;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct", mappedBy="idorder")
     */
    protected $orderProducts;

    /**
     * Set orderdatecurrent
     * Ustawienie aktualnej daty-godziny.
     * wystarczy na rzecz instancji zamówienia odpalić te funkcję
     * i w bazie danych  dodana bedzie aktualna data zakupu
     *  $order = new Order();
     *  $order->setOrderdatecurrent();
     */
    public function setOrderdatecurrent()
    {
        $this->orderdate = new DateTime();

        return $this;
    }

    /**
     * Set orderdate
     *
     * @param \DateTime $orderdate
     * @return Order
     */
    public function setOrderdate($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime
     */
    public function getOrderdate()
    {
        return $this->orderdate;
    }

    /**
     * Get idorder
     *
     * @return int
     */
    public function getIdorder()
    {
        return $this->idorder;
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
     * Set idclient
     *
     * @param \AppBundle\Entity\Client $idclient
     * @return Order
     */
    public function setIdclient(\AppBundle\Entity\Client $idclient = null)
    {
        $this->idclient = $idclient;

        return $this;
    }

    /**
     * Get idclient
     *
     * @return \AppBundle\Entity\Client
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }

    /**
     * Add invoices
     *
     * @param \AppBundle\Entity\Invoice $invoices
     * @return Order
     */
    public function addInvoices(\AppBundle\Entity\Invoice $invoices)
    {
        $this->invoices[] = $invoices;

        return $this;
    }

    /**
     * Remove invoices
     *
     * @param \AppBundle\Entity\Invoice $invoices
     */
    public function removeInvoices(\AppBundle\Entity\Invoice $invoices)
    {
        $this->invoices->removeElement($invoices);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Add shipments
     *
     * @param \AppBundle\Entity\Shipment $shipments
     * @return Order
     */
    public function addShipments(\AppBundle\Entity\Shipment $shipments)
    {
        $this->shipments[] = $shipments;

        return $this;
    }

    /**
     * Remove shipments
     *
     * @param \AppBundle\Entity\Shipment $shipments
     */
    public function removeShipments(\AppBundle\Entity\Shipment $shipments)
    {
        $this->shipments->removeElement($shipments);
    }

    /**
     * Get shipments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * Add orderProducts
     *
     * @param \AppBundle\Entity\OrderProduct $orderProducts
     * @return Order
     */
    public function addOrderProduct(\AppBundle\Entity\OrderProduct $orderProduct)
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
        }

        return $this;
    }

    /**
     * Remove orderProducts
     *
     * @param \AppBundle\Entity\OrderProduct $orderProducts
     */
    public function removeOrderProducts(\AppBundle\Entity\OrderProduct $orderProduct)
    {
        $this->orderProducts->removeElement($orderProduct);
    }

    /**
     * Get orderProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrderProducts()
    {
        return $this->orderProducts;
    }
}
