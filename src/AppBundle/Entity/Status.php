<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Status
 *
 * @ORM\Table(name="status")
 * @ORM\Entity
 */
class Status
{
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="idStatus", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idstatus;

    /**
     * @ORM\OneToMany(targetEntity="Purchase", mappedBy="idstatus")
     */
    protected $orders;

    /**
     * Set status
     *
     * @param string $status
     * @return Status
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get idstatus
     *
     * @return int
     */
    public function getIdstatus()
    {
        return $this->idstatus;
    }

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Purchase $orders
     * @return Status
     */
    public function addPurchases(\AppBundle\Entity\Purchase $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \AppBundle\Entity\Purchase $orders
     */
    public function removePurchases(\AppBundle\Entity\Purchase $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->orders;
    }

    public function __toString()
    {
        return $this->getStatus();
    }
}
