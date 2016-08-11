"C:\wamp\bin\php\php5.5.12\php.exe" "C:\wamp\www\Szobuk2\app\console" "--ansi" "doctrine:schema:validate"
[Mapping]  FAIL - The entity-class 'AppBundle\Entity\DaneSprzedawcy' mapping is invalid:
* The association AppBundle\Entity\DaneSprzedawcy#faktury refers to the owning side field AppBundle\Entity\Faktura#dane_sprzedawcy which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Faktura' mapping is invalid:
* The mappings AppBundle\Entity\Faktura#idsprzedawca and AppBundle\Entity\DaneSprzedawcy#faktury are inconsistent with each other.
* The mappings AppBundle\Entity\Faktura#idzamowienie and AppBundle\Entity\Zamowienie#faktury are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Klient' mapping is invalid:
* The association AppBundle\Entity\Klient#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#klient which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Ksiazka' mapping is invalid:
* The referenced column name 'idkategoria' has to be a primary key column on the target entity class 'AppBundle\Entity\Kategoria'.
* The association AppBundle\Entity\Ksiazka#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#ksiazka which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Przesylka' mapping is invalid:
* The mappings AppBundle\Entity\Przesylka#idzamowienie and AppBundle\Entity\Zamowienie#przesylki are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Status' mapping is invalid:
* The association AppBundle\Entity\Status#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#status which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Zamowienie' mapping is invalid:
* The mappings AppBundle\Entity\Zamowienie#idklient and AppBundle\Entity\Klient#zamowienia are inconsistent with each other.
* The mappings AppBundle\Entity\Zamowienie#idstatus and AppBundle\Entity\Status#zamowienia are inconsistent with each other.
* The association AppBundle\Entity\Zamowienie#faktury refers to the owning side field AppBundle\Entity\Faktura#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#przesylki refers to the owning side field AppBundle\Entity\Przesylka#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#zamowienie which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\ZamowienieProdukt' mapping is invalid:
* The mappings AppBundle\Entity\ZamowienieProdukt#isbn and AppBundle\Entity\Ksiazka#zamowienie_produkty are inconsistent with each other.
* The mappings AppBundle\Entity\ZamowienieProdukt#idzamowienie and AppBundle\Entity\Zamowienie#zamowienie_produkty are inconsistent with each other.

[Database] FAIL - The database schema is not in sync with the current mapping file.
Done.
---------------------------

"C:\wamp\bin\php\php5.5.12\php.exe" "C:\wamp\www\Szobuk2\app\console" "--ansi" "doctrine:schema:validate"
[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Faktura' mapping is invalid:
* The mappings AppBundle\Entity\Faktura#idzamowienie and AppBundle\Entity\Zamowienie#faktury are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Klient' mapping is invalid:
* The association AppBundle\Entity\Klient#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#klient which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Ksiazka' mapping is invalid:
* The referenced column name 'idkategoria' has to be a primary key column on the target entity class 'AppBundle\Entity\Kategoria'.
* The association AppBundle\Entity\Ksiazka#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#ksiazka which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Przesylka' mapping is invalid:
* The mappings AppBundle\Entity\Przesylka#idzamowienie and AppBundle\Entity\Zamowienie#przesylki are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Status' mapping is invalid:
* The association AppBundle\Entity\Status#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#status which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Zamowienie' mapping is invalid:
* The mappings AppBundle\Entity\Zamowienie#idklient and AppBundle\Entity\Klient#zamowienia are inconsistent with each other.
* The mappings AppBundle\Entity\Zamowienie#idstatus and AppBundle\Entity\Status#zamowienia are inconsistent with each other.
* The association AppBundle\Entity\Zamowienie#faktury refers to the owning side field AppBundle\Entity\Faktura#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#przesylki refers to the owning side field AppBundle\Entity\Przesylka#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#zamowienie which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\ZamowienieProdukt' mapping is invalid:
* The mappings AppBundle\Entity\ZamowienieProdukt#isbn and AppBundle\Entity\Ksiazka#zamowienie_produkty are inconsistent with each other.
* The mappings AppBundle\Entity\ZamowienieProdukt#idzamowienie and AppBundle\Entity\Zamowienie#zamowienie_produkty are inconsistent with each other.

[Database] FAIL - The database schema is not in sync with the current mapping file.
Done.
------------------------

"C:\wamp\bin\php\php5.5.12\php.exe" "C:\wamp\www\Szobuk2\app\console" "--ansi" "doctrine:schema:validate"
[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Klient' mapping is invalid:
* The association AppBundle\Entity\Klient#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#klient which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Ksiazka' mapping is invalid:
* The referenced column name 'idkategoria' has to be a primary key column on the target entity class 'AppBundle\Entity\Kategoria'.
* The association AppBundle\Entity\Ksiazka#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#ksiazka which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Przesylka' mapping is invalid:
* The mappings AppBundle\Entity\Przesylka#idzamowienie and AppBundle\Entity\Zamowienie#przesylki are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Status' mapping is invalid:
* The association AppBundle\Entity\Status#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#status which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Zamowienie' mapping is invalid:
* The mappings AppBundle\Entity\Zamowienie#idklient and AppBundle\Entity\Klient#zamowienia are inconsistent with each other.
* The mappings AppBundle\Entity\Zamowienie#idstatus and AppBundle\Entity\Status#zamowienia are inconsistent with each other.
* The association AppBundle\Entity\Zamowienie#przesylki refers to the owning side field AppBundle\Entity\Przesylka#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#zamowienie which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\ZamowienieProdukt' mapping is invalid:
* The mappings AppBundle\Entity\ZamowienieProdukt#isbn and AppBundle\Entity\Ksiazka#zamowienie_produkty are inconsistent with each other.
* The mappings AppBundle\Entity\ZamowienieProdukt#idzamowienie and AppBundle\Entity\Zamowienie#zamowienie_produkty are inconsistent with each other.

[Database] FAIL - The database schema is not in sync with the current mapping file.
Done.
-----------------

"C:\wamp\bin\php\php5.5.12\php.exe" "C:\wamp\www\Szobuk2\app\console" "--ansi" "doctrine:schema:validate"
[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Ksiazka' mapping is invalid:
* The referenced column name 'idkategoria' has to be a primary key column on the target entity class 'AppBundle\Entity\Kategoria'.
* The association AppBundle\Entity\Ksiazka#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#ksiazka which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Przesylka' mapping is invalid:
* The mappings AppBundle\Entity\Przesylka#idzamowienie and AppBundle\Entity\Zamowienie#przesylki are inconsistent with each other.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Status' mapping is invalid:
* The association AppBundle\Entity\Status#zamowienia refers to the owning side field AppBundle\Entity\Zamowienie#status which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\Zamowienie' mapping is invalid:
* The mappings AppBundle\Entity\Zamowienie#idstatus and AppBundle\Entity\Status#zamowienia are inconsistent with each other.
* The association AppBundle\Entity\Zamowienie#przesylki refers to the owning side field AppBundle\Entity\Przesylka#zamowienie which does not exist.
* The association AppBundle\Entity\Zamowienie#zamowienie_produkty refers to the owning side field AppBundle\Entity\ZamowienieProdukt#zamowienie which does not exist.

[Mapping]  FAIL - The entity-class 'AppBundle\Entity\ZamowienieProdukt' mapping is invalid:
* The mappings AppBundle\Entity\ZamowienieProdukt#isbn and AppBundle\Entity\Ksiazka#zamowienie_produkty are inconsistent with each other.
* The mappings AppBundle\Entity\ZamowienieProdukt#idzamowienie and AppBundle\Entity\Zamowienie#zamowienie_produkty are inconsistent with each other.

[Database] FAIL - The database schema is not in sync with the current mapping file.
Done.

