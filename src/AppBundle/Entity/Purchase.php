<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Purchase
 *
 * @ORM\Table(name="purchase", indexes={@ORM\Index(name="idClient_idx", columns={"idClient"}), @ORM\Index(name="idStatus_idx", columns={"idStatus"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseRepository")
 */
class Purchase
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchaseDate", type="datetime", nullable=true)
     */
    private $purchasedate;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPurchase", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpurchase;

    /**
     * @var \AppBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Client", inversedBy="purchases")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     * })
     */
    private $idclient;

    /**
     * @var \AppBundle\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status", inversedBy="purchases")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idStatus", referencedColumnName="idStatus")
     * })
     */
    private $idstatus;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Invoice", mappedBy="idpurchase")
     */
    protected $invoices;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Shipment", mappedBy="idpurchase")
     */
    protected $shipments;

    /**
     * @ORM\OneToMany(targetEntity="PurchaseProduct", mappedBy="idpurchase")
     */
    protected $purchaseProducts;

    /**
     * Set purchasedatecurrent
     * Ustawienie aktualnej daty-godziny.
     * wystarczy na rzecz instancji zamówienia odpalić te funkcję
     * i w bazie danych  dodana bedzie aktualna data zakupu
     *  $purchase = new Purchase();
     *  $purchase->setPurchasedatecurrent();
     */
    public function setPurchasedatecurrent()
    {
        $this->purchasedate = new DateTime();

        return $this;
    }

    /**
     * Set purchasedate
     *
     * @param \DateTime $purchasedate
     * @return Purchase
     */
    public function setPurchasedate($purchasedate)
    {
        $this->purchasedate = $purchasedate;

        return $this;
    }

    /**
     * Get purchasedate
     *
     * @return \DateTime
     */
    public function getPurchasedate()
    {
        return $this->purchasedate;
    }

    /**
     * Get idpurchase
     *
     * @return int
     */
    public function getIdpurchase()
    {
        return $this->idpurchase;
    }

    /**
     * Set idstatus
     *
     * @param \AppBundle\Entity\Status $idstatus
     * @return Purchase
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
     * @return Purchase
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
        $this->purchaseProducts = new ArrayCollection();
    }

    /**
     * Add invoices
     *
     * @param \AppBundle\Entity\Invoice $invoices
     * @return Purchase
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
     * @return Purchase
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
     * Add purchaseProducts
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProducts
     * @return Purchase
     */
    public function addPurchaseProduct(\AppBundle\Entity\PurchaseProduct $purchaseProduct)
    {
        if (!$this->purchaseProducts->contains($purchaseProduct)) {
            $this->purchaseProducts[] = $purchaseProduct;
        }

        return $this;
    }

    /**
     * Remove purchaseProducts
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProducts
     */
    public function removePurchaseProducts(\AppBundle\Entity\PurchaseProduct $purchaseProduct)
    {
        $this->purchaseProducts->removeElement($purchaseProduct);
    }

    /**
     * Get purchaseProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchaseProducts()
    {
        return $this->purchaseProducts;
    }
}
