<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Merchant
 *
 * @ORM\Table(name="merchant")
 * @ORM\Entity
 */
class Merchant
{
    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=45, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="houseNumber", type="string", length=45, nullable=true)
     */
    private $housenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="apartmentNumber", type="string", length=45, nullable=true)
     */
    private $apartmentnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=45, nullable=true)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=45, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=45, nullable=true)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=45, nullable=true)
     */
    private $phonenumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="idMerchant", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmerchant;

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="idmerchant")
     */
    protected $invoices;

    /**
     * Set name
     *
     * @param string $name
     * @return Merchant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getname()
    {
        return $this->name;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Merchant
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set housenumber
     *
     * @param string $housenumber
     * @return Merchant
     */
    public function setHousenumber($housenumber)
    {
        $this->housenumber = $housenumber;

        return $this;
    }

    /**
     * Get housenumber
     *
     * @return string
     */
    public function getHousenumber()
    {
        return $this->housenumber;
    }

    /**
     * Set apartmentnumber
     *
     * @param string $apartmentnumber
     * @return Merchant
     */
    public function setApartmentNumber($apartmentnumber)
    {
        $this->apartmentnumber = $apartmentnumber;

        return $this;
    }

    /**
     * Get apartmentnumber
     *
     * @return string
     */
    public function getApartmentNumber()
    {
        return $this->apartmentnumber;
    }

    /**
     * Set postalcode
     *
     * @param string $postalcode
     * @return Merchant
     */
    public function setPostalcode($postalcode)
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    /**
     * Get postalcode
     *
     * @return string
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Merchant
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Merchant
     */
    public function setNip($nip)
    {
        $this->nip = $nip;

        return $this;
    }

    /**
     * Get nip
     *
     * @return string
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     * @return Merchant
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Get idmerchant
     *
     * @return int
     */
    public function getidMerchant()
    {
        return $this->idmerchant;
    }

    /**
     * Get invoices
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Add invoices
     *
     * @param \AppBundle\Entity\Invoice $invoices
     * @return Merchant
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
}
