<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints AS Assert;
use AppBundle\Validator\Constraints as AcmeAssert;

/**
 * Klient.
 * 
 * Contraints rules messages NIE DZIAŁA. To jest zasady tu podane obowiązują,
 * ale komunikaty błędów walidacji są domyślne dla przeglądarki i HTML5. 
 * Mimo, że robione wg dokumentacji SYmfony2
 *
 * @ORM\Table(name="klient", indexes={@ORM\Index(name="idLogowanie_idx", columns={"idLogowanie"})})
 * @ORM\Entity
 */
class Klient
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
     * @ORM\Column(name="imie", type="string", length=45, nullable=false)
     */
    private $imie;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Nazwisko powinno zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Nazwisko powinno zawierać nie więcej niż {{ limit }} znaków"
     * )
     * @ORM\Column(name="nazwisko", type="string", length=45, nullable=false)
     */
    private $nazwisko;

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
     * @ORM\Column(name="ulica", type="string", length=45, nullable=false)
     */
    private $ulica;

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
     * @ORM\Column(name="nrDomu", type="string", length=10, nullable=false)
     */
    private $nrdomu;

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
     * @ORM\Column(name="nrMieszkania", type="string", length=10, nullable=true)
     */
    private $nrmieszkania;

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 6,
     *      max = 6,
     *      exactMessage = "Kod pocztowy powinien składać się z {{ limit }} znaków w formacie CC-CCC",
     * )
     * 
     * @ORM\Column(name="kodPocztowy", type="string", length=6, nullable=true)
     */
    private $kodpocztowy;

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
     * @ORM\Column(name="miasto", type="string", length=45, nullable=false)
     */
    private $miasto;

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
     * @ORM\Column(name="nrTelefonu", type="string", length=45, nullable=true)
     */
    private $nrtelefonu;

    /**
     * @var integer
     *
     * @ORM\Column(name="idKlient", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idklient;

    /**
     * @var \My\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="My\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idlogowanie", referencedColumnName="id")
     * })
     */
    private $idlogowanie;

        
    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\Zamowienie", mappedBy="idklient")
    */
    protected $zamowienia;


    /**
     * Set imie
     *
     * @param string $imie
     * @return Klient
     */
    public function setImie($imie)
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Klient
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Klient
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
     * Set ulica
     *
     * @param string $ulica
     * @return Klient
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;

        return $this;
    }

    /**
     * Get ulica
     *
     * @return string 
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * Set nrdomu
     *
     * @param string $nrdomu
     * @return Klient
     */
    public function setNrdomu($nrdomu)
    {
        $this->nrdomu = $nrdomu;

        return $this;
    }

    /**
     * Get nrdomu
     *
     * @return string 
     */
    public function getNrdomu()
    {
        return $this->nrdomu;
    }

    /**
     * Set nrmieszkania
     *
     * @param string $nrmieszkania
     * @return Klient
     */
    public function setNrmieszkania($nrmieszkania)
    {
        $this->nrmieszkania = $nrmieszkania;

        return $this;
    }

    /**
     * Get nrmieszkania
     *
     * @return string 
     */
    public function getNrmieszkania()
    {
        return $this->nrmieszkania;
    }

    /**
     * Set kodpocztowy
     *
     * @param string $kodpocztowy
     * @return Klient
     */
    public function setKodpocztowy($kodpocztowy)
    {
        $this->kodpocztowy = $kodpocztowy;

        return $this;
    }

    /**
     * Get kodpocztowy
     *
     * @return string 
     */
    public function getKodpocztowy()
    {
        return $this->kodpocztowy;
    }

    /**
     * Set miasto
     *
     * @param string $miasto
     * @return Klient
     */
    public function setMiasto($miasto)
    {
        $this->miasto = $miasto;

        return $this;
    }

    /**
     * Get miasto
     *
     * @return string 
     */
    public function getMiasto()
    {
        return $this->miasto;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Klient
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
     * Set nrtelefonu
     *
     * @param string $nrtelefonu
     * @return Klient
     */
    public function setNrtelefonu($nrtelefonu)
    {
        $this->nrtelefonu = $nrtelefonu;

        return $this;
    }

    /**
     * Get nrtelefonu
     *
     * @return string 
     */
    public function getNrtelefonu()
    {
        return $this->nrtelefonu;
    }

    /**
     * Get idklient
     *
     * @return integer 
     */
    public function getIdklient()
    {
        return $this->idklient;
    }

    /**
     * Set idlogowanie
     *
     * @param \My\UserBundle\Entity\User $id
     * @return Klient
     */
    public function setIdlogowanie(\My\UserBundle\Entity\User $id = null)
    {
        $this->idlogowanie = $id;

        return $this;
    }

    /**
     * Get idlogowanie
     *
     * @return \My\UserBundle\Entity\User
     */
    public function getIdlogowanie()
    {
        return $this->idlogowanie;
    }
    
    public function __construct() {
        $this->zamowienia = new ArrayCollection();
    }  

    /**
     * Add zamowienia
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienia
     * @return Klient
     */
    public function addZamowienium(\AppBundle\Entity\Zamowienie $zamowienia)
    {
        $this->zamowienia[] = $zamowienia;

        return $this;
    }

    /**
     * Remove zamowienia
     *
     * @param \AppBundle\Entity\Zamowienie $zamowienia
     */
    public function removeZamowienium(\AppBundle\Entity\Zamowienie $zamowienia)
    {
        $this->zamowienia->removeElement($zamowienia);
    }

    /**
     * Get zamowienia
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZamowienia()
    {
        return $this->zamowienia;
    }

}
