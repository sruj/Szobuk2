<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * OrderProduct
 *
 * @ORM\Table(name="zamowienie_produkt", indexes={@ORM\Index(name="idZamowienie_idx", columns={"idZamowienie"}), @ORM\Index(name="isbn_idx", columns={"isbn"})})
 * @ORM\Entity
 */
class OrderProduct
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
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

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
     * @var \AppBundle\Entity\Book
     *
     * @ORM\ManyToOne(targetEntity="Book.php", inversedBy="zamowienie_produkty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="isbn", referencedColumnName="isbn")
     * })
     */
    private $isbn;




    /**
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Order.php", inversedBy="zamowienie_produkty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idZamowienie", referencedColumnName="idZamowienie")
     * })
     */
    private $idorder;



    /**
     * Set ilosc
     *
     * @param int $ilosc
     * @return OrderProduct
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return int
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set cenaproduktu
     *
     * @param string $cenaproduktu
     * @return OrderProduct
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
     * @return OrderProduct
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
     * Set title
     *
     * @param string $title
     * @return OrderProduct
     */
    public function setTytul($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTytul()
    {
        return $this->title;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return OrderProduct
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
     * @return int
     */
    public function getIdzamowienieprodukt()
    {
        return $this->idzamowienieprodukt;
    }

    /**
     * Set isbn
     *
     * @param \AppBundle\Entity\Book $isbn
     * @return OrderProduct
     */
    public function setIsbn(\AppBundle\Entity\Book $isbn = null)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return \AppBundle\Entity\Book
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set idorder
     *
     * @param \AppBundle\Entity\Order $idorder
     * @return OrderProduct
     */
    public function setIdzamowienie(\AppBundle\Entity\Order $zamowienie = null)
    {
        $this->idorder = $zamowienie;
        $zamowienie->addZamowienieProdukt($this);

        return $this;
    }

    /**
     * Get idorder
     *
     * @return \AppBundle\Entity\Order
     */
    public function getIdzamowienie()
    {
        return $this->idorder;
    }
}
