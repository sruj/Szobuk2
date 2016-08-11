<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ksiazka
 *
 * @ORM\Table(name="ksiazka", indexes={@ORM\Index(name="idKategoria_idx", columns={"idKategoria"})})
 * @ORM\Entity
 */
class Ksiazka
{
    
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
     * @Assert\Isbn
     * @ORM\Column(name="isbn", type="string", length=45)
     * @ORM\Id
     */
    private $isbn;
    
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
    private $cena;

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
     *
     * @ORM\Column(name="rokWydania", type="string", length=45, nullable=true)
     */
    private $rokwydania;

    /**
     * @var integer
     *
     * @ORM\Column(name="ilosc", type="integer",  nullable=false)
     */
    private $ilosc;



//    Było. Automatycznie wygenerowane bez inversedBy.
//    /**
//     * @var \AppBundle\Entity\Kategoria
//     *
//     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kategoria")
//     * @ORM\JoinColumns({
//     *   @ORM\JoinColumn(name="idKategoria", referencedColumnName="idKategoria")
//     * })
//     */
//    private $idkategoria;
    
    /**
     * @var \AppBundle\Entity\Kategoria
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Kategoria", inversedBy="ksiazki")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idkategoria", referencedColumnName="idKategoria")
     * })
     */
    private $idkategoria;
    
    /**
    * @ORM\OneToMany(targetEntity="AppBundle\Entity\ZamowienieProdukt", mappedBy="isbn")
    */
    protected $zamowienie_produkty;

//
//    /**
//     * Set autor
//     *
//     * @param string $autor
//     * @return Ksiazka
//     */
//    public function setAutor($autor)
//    {
//        $this->autor = $autor;
//
//        return $this;
//    }
//
//    /**
//     * Get autor
//     *
//     * @return string 
//     */
//    public function getAutor()
//    {
//        return $this->autor;
//    }
//
//    /**
//     * Set opis
//     *
//     * @param string $opis
//     * @return Ksiazka
//     */
//    public function setOpis($opis)
//    {
//        $this->opis = $opis;
//
//        return $this;
//    }
//
//    /**
//     * Get opis
//     *
//     * @return string 
//     */
//    public function getOpis()
//    {
//        return $this->opis;
//    }
//
//    /**
//     * Set cena
//     *
//     * @param string $cena
//     * @return Ksiazka
//     */
//    public function setCena($cena)
//    {
//        $this->cena = $cena;
//
//        return $this;
//    }
//
//    /**
//     * Get cena
//     *
//     * @return string 
//     */
//    public function getCena()
//    {
//        return $this->cena;
//    }
//
//    /**
//     * Set obrazek
//     *
//     * @param string $obrazek
//     * @return Ksiazka
//     */
//    public function setObrazek($obrazek)
//    {
//        $this->obrazek = $obrazek;
//
//        return $this;
//    }
//
//    /**
//     * Get obrazek
//     *
//     * @return string 
//     */
//    public function getObrazek()
//    {
//        return $this->obrazek;
//    }
//
//    /**
//     * Set wydawnictwo
//     *
//     * @param string $wydawnictwo
//     * @return Ksiazka
//     */
//    public function setWydawnictwo($wydawnictwo)
//    {
//        $this->wydawnictwo = $wydawnictwo;
//
//        return $this;
//    }
//
//    /**
//     * Get wydawnictwo
//     *
//     * @return string 
//     */
//    public function getWydawnictwo()
//    {
//        return $this->wydawnictwo;
//    }
//
//    /**
//     * Set rokwydania
//     *
//     * @param string $rokwydania
//     * @return Ksiazka
//     */
//    public function setRokwydania($rokwydania)
//    {
//        $this->rokwydania = $rokwydania;
//
//        return $this;
//    }
//
//    /**
//     * Get rokwydania
//     *
//     * @return string 
//     */
//    public function getRokwydania()
//    {
//        return $this->rokwydania;
//    }
//
//    /**
//     * Get isbn
//     *
//     * @return string 
//     */
//    public function getIsbn()
//    {
//        return $this->isbn;
//    }
//
//    /**
//     * Set idkategoria
//     *
//     * @param \AppBundle\Entity\Kategoria $idkategoria
//     * @return Ksiazka
//     */
//    public function setIdkategoria(\AppBundle\Entity\Kategoria $idkategoria = null)
//    {
//        $this->idkategoria = $idkategoria;
//
//        return $this;
//    }
//
//    /**
//     * Get idkategoria
//     *
//     * @return \AppBundle\Entity\Kategoria 
//     */
//    public function getIdkategoria()
//    {
//        return $this->idkategoria;
//    }

    
    
    
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
     * @return Ksiazka
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
     * Set tytul
     *
     * @param string $tytul
     * @return Ksiazka
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
     * @return Ksiazka
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
     * @return Ksiazka
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
     * @param string $cena
     * @return Ksiazka
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return string 
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set obrazek
     *
     * @param string $obrazek
     * @return Ksiazka
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
     * @return Ksiazka
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
     * @return Ksiazka
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
     * @param integer $ilosc
     * @return Ksiazka
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get rokwydania
     *
     * @return integer 
     */
    public function getilosc()
    {
        return $this->ilosc;
    }



    /**
     * Set idkategoria
     *
     * @param \AppBundle\Entity\Kategoria $idkategoria
     * @return Ksiazka
     */
    public function setIdkategoria(\AppBundle\Entity\Kategoria $idkategoria = null)
    {
        $this->idkategoria = $idkategoria;

        return $this;
    }

    /**
     * Get idkategoria
     *
     * @return \AppBundle\Entity\Kategoria 
     */
    public function getIdkategoria()
    {
        return $this->idkategoria;
    }
    
    public function __construct() {
        $this->zamowienie_produkty = new ArrayCollection();
    }     

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Ksiazka
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
     * @return Ksiazka
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Add zamowienie_produkty
     *
     * @param \AppBundle\Entity\ZamowienieProdukt $zamowienieProdukty
     * @return Ksiazka
     */
    public function addZamowienieProdukty(\AppBundle\Entity\ZamowienieProdukt $zamowienieProdukty)
    {
        $this->zamowienie_produkty[] = $zamowienieProdukty;

        return $this;
    }

    /**
     * Remove zamowienie_produkty
     *
     * @param \AppBundle\Entity\ZamowienieProdukt $zamowienieProdukty
     */
    public function removeZamowienieProdukty(\AppBundle\Entity\ZamowienieProdukt $zamowienieProdukty)
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
