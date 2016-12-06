Księgarnia/Sklep - Symfony2.8
========================

Projekt zaliczeniowy jako praca dyplomowa inżynierska obroniona 13-11-2015. Do dziś wprowadzane nowe funkcjonalności w ramach nauki. Jest to mój pierwszy i jedyny projekt w Symfony. Projekt ten nigdy nie powstawał z zamiarem późniejszego udostępniania jako pokaz moich umiejętności, stąd mogą mocno razić np. mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych lub kometarze.

Uwagi:
----------------------------------
- Projekt ten nigdy nie powstawał z zamiarem późniejszego udostęnniania jako pokaz moich umiejętności.
- beznadziejne mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych wynika z tego, że projekt rozpoczynałem w momencie nauki PHP/Symfony na podstawie polskojęzycznych książek, gdzie stosowano polskie nazwy zmiennych/metod/klas. (Późniejsze potworki typu "getZamowienieProdukt", "findNowosci" wynikały z konieczności łączenia nazw klas Entity z konwencjami nazewnictwa Symfony, itp). 

Zastosowane m.in.:
----------------------------------

### 1) Symfony

  * services, (directives: factory,tags,arguments) np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/config/services.yml

  * custom event-listener, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php#L70
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Event/OrderPlacedEvent.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/EventListener/SendEmailNotificationToAdminListener.php
  
  * security (firewalls, access_control, role_hierarchy)
  
  https://github.com/sruj/szobuk2/blob/master/app/config/security.yml
    

  * form (custom form type, form in controller) np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Form/KsiazkaIloscType.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/KsiazkaController.php#L262
  
  * configuration form in twig
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/zamawiam.html.twig

  * form handler outside controller, custom service,  np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/CreateZamowienieFormHandler.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/config/services.yml#L34
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/CartController.php#L161


  * custom validation constraints, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Validator/Constraints/PhoneNumberValidator.php
  
  * custom exceptions
  
  (brak)

  

  * custom Twig functions (twig extension) , np:
  
  https://github.com/sruj/szobuk2/blob/master/app/config/services.yml#L14
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Twig/AppExtension.php
  
 
  * EntityRepository
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/KsiazkaRepository.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/ZamowienieRepository.php
  
    ```
   * @ORM\Entity(repositoryClass="AppBundle\Repository\ZamowienieRepository")
   */
   class Zamowienie
   {
    ```

  * FOSUserBundle - views override, np:
  
  https://github.com/sruj/szobuk2/tree/master/app/Resources/FOSUserBundle/views
  
  * [Collection of Forms](https://symfony.com/doc/current/form/form_collections.html), np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/KsiazkaController.php#L44
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/KsiazkaList.php
  
  

  * friendly configuration, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/DependencyInjection/Configuration.php

  * knp-paginator, knp_pagination_sortable np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Default/popularne.html.twig#L21
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Ksiazka/index.html.twig#L42
  
  * restrict content in twig (ROLE_ADMIN), np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Kategoria/edit.html.twig#L8

### 2) Doctrine ORM

  * Association Mapping, np:
  
   ```
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ksiazka", inversedBy="zamowienie_produkty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="isbn", referencedColumnName="isbn")
     * })
     */
    private $isbn;
     ```
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/ZamowienieProdukt.php#L63  
  
  * [edit] coś takiego (z ArrayCollection)  , np:
  
  ```
    public function __construct() {
        $this->faktury = new ArrayCollection();
        $this->zamowienie_produkty = new ArrayCollection();
    }  
    public function addZamowienieProdukt(\AppBundle\Entity\ZamowienieProdukt $zamowienieProdukt)
    {
        if(!$this->zamowienie_produkty->contains($zamowienieProdukt)) {
            $this->zamowienie_produkty[] = $zamowienieProdukt;
        }
        return $this;
    }
    public function getZamowienieProdukty()
    {
        return $this->zamowienie_produkty;
    }
    ```

  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/Zamowienie.php#L177
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/Zamowienie.php#L255
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/ZamowienieProdukt.php#L239
  
  * Gedmo\Timestampable, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/Ksiazka.php#L28

  
  * Validation, np:
  
  ```
     * @Assert\Length(
     *      min = 2,
     *      max = 45,
     *      minMessage = "Imię powinno zawierać co najmniej {{ limit }} znaków",
     *      maxMessage = "Imię powinno zawierać nie więcej niż {{ limit }} znaków"
     * )
     * @ORM\Column(name="imie", type="string", length=45, nullable=false)
     */
    private $imie;
    ```
    
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/Klient.php#L25
  
  * Fixtures
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/DataFixtures/ORM/LoadKategoriaData.php
  

  * DQL
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/ZamowienieRepository.php
  
### 3) JavaScript, Ajax

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/public/js/aktualizacjaKoszyka.js
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/cartmenu.html.twig#L58


### 4) CSS

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/public/css/style.css


### 5) Testy funkcjonalne, np:

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Controller/ZarzadcaControllerTest.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Utils/ColumnSortChecker.php

### 6) Testy jednostkowe


### 7) Twig

  * blocks, include, extends, filters, functions, trans_default_domain itd., np:
  
  https://github.com/sruj/szobuk2/blob/master/app/Resources/FOSUserBundle/views/Registration/confirmed.html.twig



