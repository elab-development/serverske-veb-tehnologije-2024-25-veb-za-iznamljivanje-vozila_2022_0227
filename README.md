# Serverska aplikacija za iznajmljivanje vozila

## Opis aplikacije
Ova aplikacija omogucava korisnicima da pregledaju i rezervisu vozila, dok administratori imaju mogucnost da dodaju, brisu i azuriraju podatke o rezervacijama i vozilima.

## Tehnologije
- **Laravel 11 (PHP Framework)**  
- **MySQL** – baza podataka  
- **Laravel Sanctum** – autentifikacija tokenima  
- **Spatie Permission** – upravljanje ulogama i privilegijama  
- **REST API** – komunikacija između klijenta i servera  
- **Postman** – testiranje API ruta

## Funkcionalnosti
-  Registracija i prijava korisnika  
-  Pregled i pretraga vozila  
-  Provera dostupnosti vozila  
-  Kreiranje, azuriranje i brisanje rezervacija  
-  Administratorske CRUD operacije  
-  Konverzija cena (spoljni API – api.exchangerate-api.com)  
-  Prikaz lokacije korisnika (spoljni API – apiip.net)

## Pokretanje projekta na sopstvenom računaru

Da biste pokrenuli aplikaciju pratite sledece korake:

---

### Klonirajte repozitorijum
1. Otvorite terminal i preuzmite projekat:
  ```bash
  git clone https://github.com/elab-development/serverske-veb-tehnologije-2024-25-veb-za-iznamljivanje-vozila_2022_0227.git
  cd backend
  ```
2. Instalirajte dependencije
     Projekat koristi Composer za PHP pakete.
     Pokrenite:
      ```bash
     composer install
      ```
3. Podesite .env fajl
     Kopirajte postojeci .env.example i kreirajte novi .env fajl:
    ```bash
    cp .env.example .env
    ```
    Zatim u njemu podesite parametre baze podataka (primer):
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3307
    DB_DATABASE=iznajmljivanjevozila
    DB_USERNAME=root
    DB_PASSWORD=
    ```
4. Generisite kljuc aplikacije
    Laravel koristi enkripcioni kljuc za sigurnost.
    Pokrenite komandu:
    ```bash
    php artisan key:generate
    ```
5. Pokrenite migracije i inicijalne podatke
   Kreirajte strukturu baze i ubacite pocetne podatke (seedere):
   ```bash
   php artisan migrate --seed
   ```
6. Pokrenite lokalni server
   Pokrenite Laravel razvojni server:
   ```bash
   php artisan serve
   ```
