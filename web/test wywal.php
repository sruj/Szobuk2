
-------------------------------------------
-> Klasa Klient



++
    /**
    * @ORM\OneToMany(targetEntity="Zamowienie", mappedBy="klient")
    */
    private $zamowienia;

    public function __construct() {
        $this->zamowienia = new ArrayCollection();
    }    	

-------------------------------------------
-> Klasa Zamowienie



++
    /**
    * @ORM\OneToMany(targetEntity="Faktura", mappedBy="zamowienie")
    */
    private $faktury;

    public function __construct() {
        $this->faktury = new ArrayCollection();
    } 


++
    /**
    * @ORM\OneToMany(targetEntity="Przesylka", mappedBy="zamowienie")
    */
    private $przesylki;

    public function __construct() {
        $this->przesylki = new ArrayCollection();
    } 


++
    /**
    * @ORM\OneToMany(targetEntity="Zamowienie_Produkt", mappedBy="zamowienie")
    */
    private $zamowienie_produkty;

    public function __construct() {
        $this->zamowienie_produkty = new ArrayCollection();
    } 

-------------------------------------------
-> Klasa Status


++
    /**
    * @ORM\OneToMany(targetEntity="Zamowienie", mappedBy="status")
    */
    private $zamowienia;

    public function __construct() {
        $this->zamowienia = new ArrayCollection();
    } 


-------------------------------------------
-> Klasa Dane_Sprzedawcy


++
    /**
    * @ORM\OneToMany(targetEntity="Faktura", mappedBy="dane_sprzedawcy")
    */
    private $faktury;

    public function __construct() {
        $this->faktury = new ArrayCollection();
    } 


-------------------------------------------
-> Klasa Ksiazka


++
    /**
    * @ORM\OneToMany(targetEntity="Zamowienie_Produkt", mappedBy="ksiazka")
    */
    private $zamowienie_produkty;

    public function __construct() {
        $this->zamowienie_produkty = new ArrayCollection();
    } 


-------------------------------------------
-> Klasa Kategoria


++
    /**
    * @ORM\OneToMany(targetEntity="Ksiazka", mappedBy="kategoria")
    */
    private $ksiazki;

    public function __construct() {
        $this->ksiazki = new ArrayCollection();
    } 


-------------------------------------------


