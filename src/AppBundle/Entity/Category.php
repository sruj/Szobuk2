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
    private $idkategoria;

    /**
     * @ORM\OneToMany(targetEntity="Book.php", mappedBy="idkategoria")
     */
    protected $ksiazki;



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
     * Get idkategoria
     *
     * @return int
     */
    public function getIdkategoria() {
        return $this->idkategoria;
    }

    public function __construct() {
        $this->ksiazki = new ArrayCollection();
    }

    /**
     * Get ksiazki
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getKsiazki() {
        return $this->ksiazki;
    }


    /**
     * Add ksiazki
     *
     * @param \AppBundle\Entity\Book $ksiazki
     * @return Category
     */
    public function addKsiazki(\AppBundle\Entity\Book $ksiazki)
    {
        $this->ksiazki[] = $ksiazki;

        return $this;
    }

    /**
     * Remove ksiazki
     *
     * @param \AppBundle\Entity\Book $ksiazki
     */
    public function removeKsiazki(\AppBundle\Entity\Book $ksiazki)
    {
        $this->ksiazki->removeElement($ksiazki);
    }
}
