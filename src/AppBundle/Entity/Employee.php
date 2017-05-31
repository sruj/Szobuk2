<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee - nieużywane
 *
 * @ORM\Table(name="pracownik", indexes={@ORM\Index(name="idLogin_idx", columns={"idLogin"})})
 * @ORM\Entity
 */
class Employee
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=45, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="houseNumber", type="string", length=45, nullable=false)
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
     * @ORM\Column(name="city", type="string", length=45, nullable=false)
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
     * @var string
     *
     * @ORM\Column(name="stanowisko", type="string", length=45, nullable=false)
     */
    private $stanowisko;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPracownik", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpracownik;

    /**
     * @var \UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlogin", referencedColumnName="id")
     * })
     */
    private $idlogin;



    /**
     * Set name
     *
     * @param string $name
     * @return Employee
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * Set stanowisko
     *
     * @param string $stanowisko
     * @return Employee
     */
    public function setStanowisko($stanowisko)
    {
        $this->stanowisko = $stanowisko;

        return $this;
    }

    /**
     * Get stanowisko
     *
     * @return string 
     */
    public function getStanowisko()
    {
        return $this->stanowisko;
    }

    /**
     * Get idpracownik
     *
     * @return int
     */
    public function getIdpracownik()
    {
        return $this->idpracownik;
    }

    /**
     * Set idlogin
     *
     * @param \UserBundle\Entity\User $id
     * @return Client
     */
    public function setIdlogowanie(\UserBundle\Entity\User $id = null)
    {
        $this->idlogin = $id;

        return $this;
    }

    /**
     * Get idlogin
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdlogowanie()
    {
        return $this->idlogin;
    }
    
    public function __construct() {
        $this->orders = new ArrayCollection();
    }  

}
