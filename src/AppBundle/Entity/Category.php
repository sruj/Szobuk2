<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Category
 *
 * @ORM\Table(name="kategoria")
 * @ORM\Entity
 * @UniqueEntity("nazwa")
 */
class Category {

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=45, nullable=true, unique=true)
     */
    private $nazwa;

    /**
     * @var integer
     *
     * @ORM\Column(name="idCategory", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcategory;

    /**
     * @ORM\OneToMany(targetEntity="Book.php", mappedBy="idcategory")
     */
    protected $books;



    /**
     * Dodałem tę metodę bo wyświetla poniższy komunikat 
     * gdy używam CRUD:
     * 
     * A "__toString()" method was not found on the objects of type
     *  "AppBundle\Entity\Category" passed to the choice field.
     * To read a custom getter instead, set the option "property" 
     * to the desired property path.
     * 
     */
    public function __toString() {
        return $this->getNazwa();
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return Category
     */
    public function setNazwa($nazwa) {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa() {
        return $this->nazwa;
    }

    /**
     * Get idcategory
     *
     * @return int
     */
    public function getIdcategory() {
        return $this->idcategory;
    }

    public function __construct() {
        $this->books = new ArrayCollection();
    }

    /**
     * Get books
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getKsiazki() {
        return $this->books;
    }


    /**
     * Add books
     *
     * @param \AppBundle\Entity\Book $books
     * @return Category
     */
    public function addKsiazki(\AppBundle\Entity\Book $books)
    {
        $this->books[] = $books;

        return $this;
    }

    /**
     * Remove books
     *
     * @param \AppBundle\Entity\Book $books
     */
    public function removeKsiazki(\AppBundle\Entity\Book $books)
    {
        $this->books->removeElement($books);
    }
}
