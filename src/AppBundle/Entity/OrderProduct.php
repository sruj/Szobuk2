<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * OrderProduct
 *
 * @ORM\Table(name="zamowienie_produkt", indexes={@ORM\Index(name="idOrder_idx", columns={"idOrder"}), @ORM\Index(name="isbn_idx", columns={"isbn"})})
 * @ORM\Entity
 */
class OrderProduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="cenaProduktu", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $cenaproduktu;

    /**
     * @var string
     *
     * @ORM\Column(name="publishYear", type="string", length=45, nullable=true)
     */
    private $publishyear;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=45, nullable=true)
     */
    private $author;

    /**
     * @var integer
     *
     * @ORM\Column(name="idOrderProdukt", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idzamowienieprodukt;


    /**
     * @var \AppBundle\Entity\Book
     *
     * @ORM\ManyToOne(targetEntity="Book.php", inversedBy="orderProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="isbn", referencedColumnName="isbn")
     * })
     */
    private $isbn;




    /**
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="Order.php", inversedBy="orderProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOrder", referencedColumnName="idOrder")
     * })
     */
    private $idorder;



    /**
     * Set quantity
     *
     * @param int $quantity
     * @return OrderProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
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
     * Set publishyear
     *
     * @param string $publishyear
     * @return OrderProduct
     */
    public function setPublishYear($publishyear)
    {
        $this->publishyear = $publishyear;

        return $this;
    }

    /**
     * Get publishyear
     *
     * @return string 
     */
    public function getPublishYear()
    {
        return $this->publishyear;
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
     * Set author
     *
     * @param string $author
     * @return OrderProduct
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Get idzamowienieprodukt
     *
     * @return int
     */
    public function getIdorderprodukt()
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
    public function setIdorder(\AppBundle\Entity\Order $zamowienie = null)
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
    public function getIdorder()
    {
        return $this->idorder;
    }
}
