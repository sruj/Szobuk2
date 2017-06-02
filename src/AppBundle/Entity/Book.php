<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as AcmeAssert;

/**
 * @ORM\Table(name="book", indexes={@ORM\Index(name="idCategory_idx", columns={"idCategory"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 */
class Book
{
    public function __construct()
    {
        $this->purchaseProducts = new ArrayCollection();
    }

    /**
     * liczba książek na stronie (głównej)
     */
    const NUM_ITEMS = 12;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var string
     *
     * //Assert\Isbn -wyłączam bo książki od początku mają przypisane isbn w złym formacie i próba edycji książki zawsze wywala błąd walidacji isbn
     * @ORM\Column(name="isbn", type="string", length=45)
     * @ORM\Id
     */
    private $isbn;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=45, nullable=true)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="print", type="string", length=45, nullable=true)
     */
    private $print;

    /**
     * @var string
     * @Assert\Range(
     *      min = 1700,
     *      max = 2200,
     * )
     * @ORM\Column(name="publishYear", type="integer", nullable=true)
     */
    private $publishyear;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer",  nullable=false)
     */
    private $quantity;

    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="books")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcategory", referencedColumnName="idCategory")
     * })
     */
    private $idcategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseProduct", mappedBy="isbn")
     */
    protected $purchaseProducts;

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     * @return Book
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Book
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
     * @return Book
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
     * Set description
     *
     * @param string $description
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param decimal $price
     * @return Book
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Book
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set print
     *
     * @param string $print
     * @return Book
     */
    public function setPrint($print)
    {
        $this->print = $print;

        return $this;
    }

    /**
     * Get print
     *
     * @return string
     */
    public function getPrint()
    {
        return $this->print;
    }

    /**
     * Set publishyear
     *
     * @param string $publishyear
     * @return Book
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
     * @param int $quantity
     * @return Book
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set idcategory
     *
     * @param \AppBundle\Entity\Category $idcategory
     * @return Book
     */
    public function setIdcategory(\AppBundle\Entity\Category $idcategory = null)
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * Get idcategory
     *
     * @return \AppBundle\Entity\Category
     */
    public function getIdcategory()
    {
        return $this->idcategory;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Book
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Book
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Add purchaseProducts
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProducts
     * @return Book
     */
    public function addPurchaseProducts(\AppBundle\Entity\PurchaseProduct $purchaseProducts)
    {
        $this->purchaseProducts[] = $purchaseProducts;

        return $this;
    }

    /**
     * Remove purchaseProducts
     *
     * @param \AppBundle\Entity\PurchaseProduct $purchaseProducts
     */
    public function removePurchaseProducts(\AppBundle\Entity\PurchaseProduct $purchaseProducts)
    {
        $this->purchaseProducts->removeElement($purchaseProducts);
    }

    /**
     * Get purchaseProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchaseProducts()
    {
        return $this->purchaseProducts;
    }
}
