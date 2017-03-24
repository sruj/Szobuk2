Księgarnia/Sklep - Symfony2.8
========================
www.test18842.futurehost.pl/ 
(domena testowa do 21-03-2017, login/hasło administratora: wazny. 

Projekt zaliczeniowy jako praca dyplomowa inżynierska obroniona 13-11-2015. Do dziś wprowadzane nowe funkcjonalności w ramach nauki. Jest to mój pierwszy i jedyny projekt w Symfony. Celowo nie została wykorzystana platforma eCommerce (np Magento), by samemu jak najwięcej pokodować. Projekt ten nigdy nie powstawał z zamiarem późniejszego udostępniania jako pokaz moich umiejętności, stąd mogą mocno razić np. mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych lub kometarze.

Uwagi:
----------------------------------
- projekt nie powstawał z zamiarem późniejszego udostępniania jako pokaz moich umiejętności.
- mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych wynika z tego, że projekt rozpoczynałem w momencie nauki PHP/Symfony na podstawie polskojęzycznych książek, gdzie stosowano polskie nazwy zmiennych/metod/klas. (Stąd potworki typu "CreateZamowienieFormHandler" wynikały np z konieczności łączenia nazw klas Entity z konwencjami nazewnictwa Symfony, aż przestałem o to dbać i poszło lawinowo). 

Zastosowane m.in.:
----------------------------------

### 1) Symfony

  * services, (directives: factory,tags,arguments) np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/config/services.yml

  * custom event-listeners, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php#L70
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Event/OrderPlacedEvent.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/EventListener/SendEmailNotificationToAdminListener.php
  
  * security (firewalls, access_control, role_hierarchy)
  
  https://github.com/sruj/szobuk2/blob/master/app/config/security.yml
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Kategoria/edit.html.twig#L8
  

  * forms
  
  form type, form in controller, np:
   
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Form/KsiazkaIloscType.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/KsiazkaController.php#L262
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/zamawiam.html.twig

  form handler outside controller, custom service,  np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/CreateZamowienieFormHandler.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/config/services.yml#L34
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/CartController.php#L161
  
  [Collection of Forms](https://symfony.com/doc/current/form/form_collections.html), np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/KsiazkaController.php#L44
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Entity/KsiazkaList.php

  custom validation constraints, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Validator/Constraints/PhoneNumberValidator.php
  
  * custom exceptions, np:
  
  https://github.com/sruj/szobuk2/tree/master/src/AppBundle/Exception
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/Cart/Cart.php#L55
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/Manager/Filter.php#L33
  

  * friendly configuration, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/DependencyInjection/Configuration.php
  
  
  * FOSUserBundle - views override, np:
  
  https://github.com/sruj/szobuk2/tree/master/app/Resources/FOSUserBundle/views

  * knp-paginator, knp_pagination_sortable np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/ZamowienieRepository.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Default/popularne.html.twig#L21
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Ksiazka/index.html.twig#L42
  
  

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
  
     
  * EntityRepository
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/KsiazkaRepository.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/ZamowienieRepository.php
  
    ```
   * @ORM\Entity(repositoryClass="AppBundle\Repository\ZamowienieRepository")
   */
   class Zamowienie
   {
    ```
  
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

* aktualizacja koszyka

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/public/js/aktualizacjaKoszyka.js
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/cartmenu.html.twig#L58

* Autosuggestion Search (podpowiadanie hasła w wyszukiwarce, na żywo)

https://github.com/sruj/szobuk2/blob/master/app/Resources/views/layout.html.twig#L35
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/KsiazkaController.php#L270

* Infinity scrolling + spinner gif (pobieranie danych z db i wyświetlanie przy skrolowaniu strony)

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Default/index.html.twig#L68

* Walidacja formularza

https://github.com/sruj/szobuk2/blob/master/src/TrenningBundle/Controller/DefaultController.php#L81

### 4) CSS

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/public/css/style.css


### 5) Testy funkcjonalne, np:

https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Controller/ZarzadcaControllerTest.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Utils/ColumnSortChecker.php

### 6) Testy jednostkowe, np:

https://github.com/sruj/szobuk2/tree/master/src/AppBundle/Tests/Utils 
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Utils/Manager/FilterQueryTest.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Utils/Manager/FilterTest.php

### 7) Twig

  * blocks, include, extends, filters, functions, trans_default_domain itd., np:
  
  https://github.com/sruj/szobuk2/blob/master/app/Resources/FOSUserBundle/views/Registration/confirmed.html.twig
    

  * custom functions (twig extension) , np:
  
  https://github.com/sruj/szobuk2/blob/master/app/config/services.yml#L14
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Twig/AppExtension.php



