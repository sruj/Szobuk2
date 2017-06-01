<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OrderProduct
 *
 * @ORM\Table(name="order_product", indexes={@ORM\Index(name="idOrder_idx", columns={"idOrder"}), @ORM\Index(name="isbn_idx", columns={"isbn"})})
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
     * @ORM\Column(name="idOrderProduct", type="integer")
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
     * @var \AppBundle\Entity\Order
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order", inversedBy="orderProducts")
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
     * Set productprice
     *
     * @param string $productprice
     * @return OrderProduct
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
    public function setIdorder(\AppBundle\Entity\Order $order = null)
    {
        $this->idorder = $order;
        $order->addOrderProduct($this);

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
