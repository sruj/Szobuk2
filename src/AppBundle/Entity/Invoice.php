<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Invoice - nieużywane
 *
 * @ORM\Table(name="invoice", indexes={@ORM\Index(name="idPurchase_idx", columns={"idPurchase"}), @ORM\Index(name="idMerchant_idx", columns={"idMerchant"})})
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="invoiceDate", type="date", nullable=true)
     */
    private $invoicedate;

    /**
     * @var string
     *
     * @ORM\Column(name="invoiceNumber", type="string", length=45)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $invoicenumber;

    /**
     * @var \AppBundle\Entity\Merchant
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Merchant", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMerchant", referencedColumnName="idMerchant")
     * })
     */
    private $idmerchant;

    /**
     * @var \AppBundle\Entity\Purchase
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="invoices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPurchase", referencedColumnName="idPurchase")
     * })
     */
    private $idorder;

    /**
     * Set invoicedate
     *
     * @param \DateTime $invoicedate
     * @return Invoice
     */
    public function setInvoicedate($invoicedate)
    {
        $this->invoicedate = $invoicedate;

        return $this;
    }

    /**
     * Get invoicedate
     *
     * @return \DateTime
     */
    public function getInvoicedate()
    {
        return $this->invoicedate;
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
     * Set idmerchant
     *
     * @param \AppBundle\Entity\Merchant $idmerchant
     * @return Invoice
     */
    public function setidMerchant(\AppBundle\Entity\Merchant $idmerchant = null)
    {
        $this->idmerchant = $idmerchant;

        return $this;
    }

    /**
     * Get idmerchant
     *
     * @return \AppBundle\Entity\Merchant
     */
    public function getidMerchant()
    {
        return $this->idmerchant;
    }

    /**
     * Set idorder
     *
     * @param \AppBundle\Entity\Purchase $idorder
     * @return Invoice
     */
    public function setIdorder(\AppBundle\Entity\Purchase $idorder = null)
    {
        $this->idorder = $idorder;

        return $this;
    }

    /**
     * Get idorder
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getIdorder()
    {
        return $this->idorder;
    }
}
