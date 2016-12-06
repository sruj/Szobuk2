Księgarnia/Sklep - Symfony2.8
========================

Projekt zaliczeniowy jako praca dyplomowa inżynierska obroniona 13-11-2015. Do dziś wprowadzane nowe funkcjonalności w ramach nauki. Jest to mój pierwszy i jedyny projekt w Symfony. Projekt ten nigdy nie powstawał z zamiarem późniejszego udostępniania jako pokaz moich umiejętności, stąd mogą mocno razić np. mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych lub kometarze.

Uwagi:
----------------------------------
- Projekt ten nigdy nie powstawał z zamiarem późniejszego udostęnniania jako pokaz moich umiejętności.
- beznadziejne mieszane polsko-angielskie nazewnictwo klas/metod/zmiennych wynika z tego, że projekt rozpoczynałem w momencie nauki PHP/Symfony na podstawie polskojęzycznych książek, gdzie stosowano polskie nazwy zmiennych/metod/klas. (Późniejsze potworki typu "getZamowienieProdukt" wynikały z konieczności łączenia nazw klas Entity, itp). 

Zastosowane m.in.:
----------------------------------

### 1) Symfony

  * własne usługi (services), np:
  
    
  * entity


  * custom event-listener, np:
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php#L70
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Event/OrderPlacedEvent.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/EventListener/SendEmailNotificationToAdminListener.php

  * custom form type, np:
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Form/KsiazkaIloscType.php
  
  * configuration form in twig
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/zamawiam.html.twig



  * form handler outside controller, custom service,  np:
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/CreateZamowienieFormHandler.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Utils/ZamowienieManager.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/config/services.yml#L34
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Controller/CartController.php#L161


  * custom validation constraints, np:
  
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Validator/Constraints/PhoneNumberValidator.php
  

  * custom Twig functions (twig extension) , np:
  
  https://github.com/sruj/szobuk2/blob/master/app/config/services.yml#L14
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Twig/AppExtension.php
  

  * własne listener-events, np:
 
 
  * EntityRepository
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/KsiazkaRepository.php
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Repository/ZamowienieRepository.php
  

  * FOSUserBundle - views override, np:

  * friendly configuration, np:

  * knp-paginator, knp_pagination_sortable np:
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Default/popularne.html.twig#L21
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Ksiazka/index.html.twig#L42
  
  * restrict content in twig (ROLE_ADMIN), np:
  https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Kategoria/edit.html.twig#L8



### 2) JavaScript, Ajax
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/public/js/aktualizacjaKoszyka.js
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Resources/views/Cart/cartmenu.html.twig#L58


### 3) CSS




### 4) DQL


### 5) Testy funkcjonalne, np:
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Controller/ZarzadcaControllerTest.php
https://github.com/sruj/szobuk2/blob/master/src/AppBundle/Tests/Utils/ColumnSortChecker.php

### 6) Testy jednostkowe



### 4) Twig
  * blocks
  * filters
  * functions
  * itd.



