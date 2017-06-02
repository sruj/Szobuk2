<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints AS Assert;
use AppBundle\Validator\Constraints as AcmeAssert;

/**
 * Client.
 *
 * Contraints rules messages NIE DZIAŁA. To jest zasady tu podane obowiązują,
 * ale komunikaty błędów walidacji są domyślne dla przeglądarki i HTML5.
 * Mimo, że robione wg dokumentacji SYmfony2
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="idLogin_idx", columns={"idLogin"})})
 * @ORM\Entity
 */
class Client
{
    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Imię powinno zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Imię powinno zawierać nie więcej niż {{ limit }} znaków"
     * )
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Nazwisko powinno zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Nazwisko powinno zawierać nie więcej niż {{ limit }} znaków"
     * )
     * @ORM\Column(name="surname", type="string", length=45, nullable=false)
     */
    private $surname;

    /**
     * @var string
     *
     * @Assert\Email
     * @ORM\Column(name="email", type="string", length=45, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Nazwa ulicy powinna zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Nazwa ulicy powinna zawierać nie więcej niż {{ limit }} znaków"
     * )
     *
     * @ORM\Column(name="street", type="string", length=45, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Numer domu powinien zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Numer domu powinien zawierać nie więcej niż {{ limit }} znaków"
     * )
     *
     * @ORM\Column(name="houseNumber", type="string", length=10, nullable=false)
     */
    private $housenumber;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Numer mieszkania powinien zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Numer mieszkania powinien zawierać nie więcej niż {{ limit }} znaków"
     * )
     *
     * @ORM\Column(name="apartmentNumber", type="string", length=10, nullable=true)
     */
    private $apartmentnumber;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 6,
     *      max = 6,
     *      exactMessage = "Kod pocztowy powinien składać się z {{ limit }} znaków w formacie CC-CCC",
     * )
     *
     * @ORM\Column(name="postalCode", type="string", length=6, nullable=true)
     */
    private $postalcode;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Nazwa miasta powinna zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Nazwa miasta powinna zawierać nie więcej niż {{ limit }} znaków"
     * )
     *
     * @ORM\Column(name="city", type="string", length=45, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      exactMessage = "NIP powinien składać się z {{ limit }} cyfr",
     * )
     *
     * @ORM\Column(name="nip", type="string", length=10, nullable=true)
     */
    private $nip;

    /**
     * @var string
     * @Assert\Length(
     *      min = 3,
     *      max = 45,
     *      minMessage = "Numer telefonu powinien składać się z cyfr i nie zawierać mniej niż {{ limit }} znaków",
     *      maxMessage = "Numer telefonu powinien składać się z cyfr i nie zawierać więcej niż {{ limit }} znaków"
     * )
     * @ORM\Column(name="phoneNumber", type="string", length=45, nullable=true)
     */
    private $phonenumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="idClient", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idclient;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="idclient")
     */
    protected $orders;


    /**
     * Set name
     *
     * @param string $name
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * @return Client
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
     * Get idclient
     *
     * @return int
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    /**
     * Set idlogin
     *
     * @param \UserBundle\Entity\User $id
     * @return Client
     */
    public function setIdlogin(\UserBundle\Entity\User $id = null)
    {
        $this->idlogin = $id;

        return $this;
    }

    /**
     * Get idlogin
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdlogin()
    {
        return $this->idlogin;
    }

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * Add orders
     *
     * @param \AppBundle\Entity\Purchase $orders
     * @return Client
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

}
