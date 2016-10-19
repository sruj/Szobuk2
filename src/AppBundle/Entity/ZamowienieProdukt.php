<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * ZamowienieProdukt
 *
 * @ORM\Table(name="zamowienie_produkt", indexes={@ORM\Index(name="idZamowienie_idx", columns={"idZamowienie"}), @ORM\Index(name="isbn_idx", columns={"isbn"})})
 * @ORM\Entity
 */
class ZamowienieProdukt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ilosc", type="integer", nullable=true)
     */
    private $ilosc;

    /**
     * @var string
     *
     * @ORM\Column(name="cenaProduktu", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cenaproduktu;

    /**
     * @var string
     *
     * @ORM\Column(name="rokWydania", type="string", length=45, nullable=true)
     */
    private $rokwydania;

    /**
     * @var string
     *
     * @ORM\Column(name="tytul", type="string", length=45, nullable=true)
     */
    private $tytul;

    /**
     * @var string
     *
     * @ORM\Column(name="autor", type="string", length=45, nullable=true)
     */
    private $autor;

    /**
     * @var integer
     *
     * @ORM\Column(name="idZamowienieProdukt", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idzamowienieprodukt;


    /**
     * @var \AppBundle\Entity\Ksiazka
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ksiazka", inversedBy="zamowienie_produkty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="isbn", referencedColumnName="isbn")
     * })
     */
    private $isbn;




    /**
     * @var \AppBundle\Entity\Zamowienie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Zamowienie", inversedBy="zamowienie_produkty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idZamowienie", referencedColumnName="idZamowienie")
     * })
     */
    private $idzamowienie;    

//
//
    /**
     * Set ilosc
     *
     * @param integer $ilosc
     * @return ZamowienieProdukt
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return integer 
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set cenaproduktu
     *
     * @param string $cenaproduktu
     * @return ZamowienieProdukt
     */
    public function setCenaproduktu($cenaproduktu)
    {
        $this->cenaproduktu = $cenaproduktu;

        return $this;
    }

    /**
     * Get cenaproduktu
     *
     * @return string 
     */
    public function getCenaproduktu()
    {
        return $this->cenaproduktu;
    }

    /**
     * Set rokwydania
     *
     * @param string $rokwydania
     * @return ZamowienieProdukt
     */
    public function setRokwydania($rokwydania)
    {
        $this->rokwydania = $rokwydania;

        return $this;
    }

    /**
     * Get rokwydania
     *
     * @return string 
     */
    public function getRokwydania()
    {
        return $this->rokwydania;
    }

    /**
     * Set tytul
     *
     * @param string $tytul
     * @return ZamowienieProdukt
     */
    public function setTytul($tytul)
    {
        $this->tytul = $tytul;

        return $this;
    }

    /**
     * Get tytul
     *
     * @return string 
     */
    public function getTytul()
    {
        return $this->tytul;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return ZamowienieProdukt
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Get idzamowienieprodukt
     *
     * @return integer 
     */
    public function getIdzamowienieprodukt()
    {
        return $this->idzamowienieprodukt;
    }

    /**
     * Set isbn
     *
     * @param \AppBundle\Entity\Ksiazka $isbn
     * @return ZamowienieProdukt
     */
    public function setIsbn(\AppBundle\Entity\Ksiazka $isbn = null)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return \AppBundle\Entity\Ksiazka 
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set idzamowienie
     *
     * @param \AppBundle\Entity\Zamowienie $idzamowienie
     * @return ZamowienieProdukt
     */
    public function setIdzamowienie(\AppBundle\Entity\Zamowienie $zamowienie = null)
    {
        $this->idzamowienie = $zamowienie;
        $zamowienie->addZamowienieProdukt($this);

        return $this;
    }

    /**
     * Get idzamowienie
     *
     * @return \AppBundle\Entity\Zamowienie 
     */
    public function getIdzamowienie()
    {
        return $this->idzamowienie;
    }
}
