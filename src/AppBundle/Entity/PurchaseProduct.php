<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PurchaseProduct
 *
 * @ORM\Table(name="order_product", indexes={@ORM\Index(name="idPurchase_idx", columns={"idPurchase"}), @ORM\Index(name="isbn_idx", columns={"isbn"})})
 * @ORM\Entity
 */
class PurchaseProduct
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
     * @ORM\Column(name="productPrice", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $productprice;

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
     * @ORM\Column(name="idPurchaseProduct", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idorderproduct;

    /**
     * @var \AppBundle\Entity\Book
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Book", inversedBy="orderProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="isbn", referencedColumnName="isbn")
     * })
     */
    private $isbn;

    /**
     * @var \AppBundle\Entity\Purchase
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="orderProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPurchase", referencedColumnName="idPurchase")
     * })
     */
    private $idorder;

    /**
     * Set quantity
     *
     * @param int $quantity
     * @return PurchaseProduct
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
     * Set productprice
     *
     * @param string $productprice
     * @return PurchaseProduct
     */
    public function setProductprice($productprice)
    {
        $this->productprice = $productprice;

        return $this;
    }

    /**
     * Get productprice
     *
     * @return string
     */
    public function getProductprice()
    {
        return $this->productprice;
    }

    /**
     * Set publishyear
     *
     * @param string $publishyear
     * @return PurchaseProduct
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
     * @return PurchaseProduct
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return PurchaseProduct
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
     * Get idorderproduct
     *
     * @return int
     */
    public function getIdorderprodukt()
    {
        return $this->idorderproduct;
    }

    /**
     * Set isbn
     *
     * @param \AppBundle\Entity\Book $isbn
     * @return PurchaseProduct
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
     * @param \AppBundle\Entity\Purchase $idorder
     * @return PurchaseProduct
     */
    public function setIdorder(\AppBundle\Entity\Purchase $order = null)
    {
        $this->idorder = $order;
        $order->addPurchaseProduct($this);

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
