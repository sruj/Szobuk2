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
     * @ORM\Column(name="autor", type="string", length=45, nullable=true)
     */
    private $autor;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", length=65535, nullable=true)
     */
    private $opis;

    /**
     * @var string
     *
     * @ORM\Column(name="cena", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="obrazek", type="string", length=45, nullable=true)
     */
    private $obrazek;

    /**
     * @var string
     *
     * @ORM\Column(name="wydawnictwo", type="string", length=45, nullable=true)
     */
    private $wydawnictwo;

    /**
     * @var string
     * @Assert\Range(
     *      min = 1700,
     *      max = 2200,
     * )
     * @ORM\Column(name="rokWydania", type="integer", nullable=true)
     */
    private $rokwydania;

    /**
     * @var integer
     *
     * @ORM\Column(name="ilosc", type="integer",  nullable=false)
     */
    private $ilosc;

    /**
     * @var \AppBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Category.php", inversedBy="ksiazki")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idkategoria", referencedColumnName="idCategory")
     * })
     */
    private $idkategoria;

    /**
     * @ORM\OneToMany(targetEntity="OrderProduct.php", mappedBy="isbn")
     */
    protected $zamowienie_produkty;

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
     * Set autor
     *
     * @param string $autor
     * @return Book
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
     * Set opis
     *
     * @param string $opis
     * @return Book
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * Set cena
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
     * Get cena
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set obrazek
     *
     * @param string $obrazek
     * @return Book
     */
    public function setObrazek($obrazek)
    {
        $this->obrazek = $obrazek;

        return $this;
    }

    /**
     * Get obrazek
     *
     * @return string
     */
    public function getObrazek()
    {
        return $this->obrazek;
    }

    /**
     * Set wydawnictwo
     *
     * @param string $wydawnictwo
     * @return Book
     */
    public function setWydawnictwo($wydawnictwo)
    {
        $this->wydawnictwo = $wydawnictwo;

        return $this;
    }

    /**
     * Get wydawnictwo
     *
     * @return string
     */
    public function getWydawnictwo()
    {
        return $this->wydawnictwo;
    }

    /**
     * Set rokwydania
     *
     * @param string $rokwydania
     * @return Book
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
     * Set rokwydania
     *
     * @param int $ilosc
     * @return Book
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get rokwydania
     *
     * @return int
     */
    public function getilosc()
    {
        return $this->ilosc;
    }

    /**
     * Set idkategoria
     *
     * @param \AppBundle\Entity\Category $idkategoria
     * @return Book
     */
    public function setIdkategoria(\AppBundle\Entity\Category $idkategoria = null)
    {
        $this->idkategoria = $idkategoria;

        return $this;
    }

    /**
     * Get idkategoria
     *
     * @return \AppBundle\Entity\Category
     */
    public function getIdkategoria()
    {
        return $this->idkategoria;
    }

    public function __construct()
    {
        $this->zamowienie_produkty = new ArrayCollection();
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
     * Add zamowienie_produkty
     *
     * @param \AppBundle\Entity\OrderProduct $zamowienieProdukty
     * @return Book
     */
    public function addZamowienieProdukty(\AppBundle\Entity\OrderProduct $zamowienieProdukty)
    {
        $this->zamowienie_produkty[] = $zamowienieProdukty;

        return $this;
    }

    /**
     * Remove zamowienie_produkty
     *
     * @param \AppBundle\Entity\OrderProduct $zamowienieProdukty
     */
    public function removeZamowienieProdukty(\AppBundle\Entity\OrderProduct $zamowienieProdukty)
    {
        $this->zamowienie_produkty->removeElement($zamowienieProdukty);
    }

    /**
     * Get zamowienie_produkty
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZamowienieProdukty()
    {
        return $this->zamowienie_produkty;
    }
}





















