<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Order
 *
 * @ORM\Table(name="zamowienie", indexes={@ORM\Index(name="idClient_idx", columns={"idClient"}), @ORM\Index(name="idStatus_idx", columns={"idStatus"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
*/
class Order
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataZlozenia", type="datetime", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="Client.php", inversedBy="orders")
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
    * @ORM\OneToMany(targetEntity="Invoice.php", mappedBy="idorder")
    */
    protected $invoices;



    /**
    * @ORM\OneToMany(targetEntity="Shipment.php", mappedBy="idorder")
    */
    protected $przesylki;



    /**
    * @ORM\OneToMany(targetEntity="ZamowienieProdukt", mappedBy="idorder")
    */
    protected $orderProducts;



    /**
     * Set orderdatecurrent
     * Ustawienie aktualnej daty-godziny.
     * wystarczy na rzecz instancji zamówienia odpalić te funkcję
     * i w bazie danych  dodana bedzie aktualna data zakupu
     *  $zamowienie = new Order();
     *  $zamowienie->setDatazlozeniacurrent();
     * 
     */
    public function setDatazlozeniacurrent()
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
    public function setDatazlozenia($orderdate)
    {
        $this->orderdate = $orderdate;

        return $this;
    }

    /**
     * Get orderdate
     *
     * @return \DateTime 
     */
    public function getDatazlozenia()
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

    public function __construct() {
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
     * Add orderProducts
     *
     * @param \AppBundle\Entity\OrderProduct $orderProducts
     * @return Order
     */
    public function addZamowienieProdukt(\AppBundle\Entity\OrderProduct $zamowienieProdukt)
    {
        if(!$this->orderProducts->contains($zamowienieProdukt)) {
            $this->orderProducts[] = $zamowienieProdukt;
        }

        return $this;
    }

    /**
     * Remove orderProducts
     *
     * @param \AppBundle\Entity\OrderProduct $orderProducts
     */
    public function removeOrderProducts(\AppBundle\Entity\OrderProduct $zamowienieProdukt)
    {
        $this->orderProducts->removeElement($zamowienieProdukt);
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
