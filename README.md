
# Mini-Projet

Il s’agit de développer une application web permettant à une communauté de cryptophiles
d'échanger sur les cryptomonnaies du métavers. Les membres de la communauté inscrits dans l'application peuvent créer
des annonces pour promouvoir des cryptomonnaies. Ils peuvent aussi émettre un avis sur les
différentes cryptomonnaies disponibles dans l'application.

## Authors

- [@Marius Guitton-Frantz](https://gitlab.univ-nantes.fr/E192265J)
- [@Evan Joubert](https://gitlab.univ-nantes.fr/E197135C)


## Deployment

To deploy this project run

Clone the repository
```bash
  git clone https://gitlab.univ-nantes.fr/E192265J/dev-web-projet.git
```

Move in the directory
```bash
  cd dev-web-projet/ProjetCrypto
```

To install dependencies
```bash
  composer install
```
To update the database schema
```bash
  php bin/console doctrine:schema:update --force        
```
To load the fixtures
```bash         
  php bin/console doctrine:fixtures:load
```

To run the php server
```bash
  php -S localhost:8000 -t public
```
## Tech Stack

**Framework:** Symfony 4.0

**Database:** phpMyAdmin


## Environment Variables

To run this project, you may have to modify your .env file

`DATABASE_URL` : your database url

 _DATABASE_URL="mysql://**user**:**password**@**database ip**:**database port**/**table**?serverVersion=**your server version**&charset=utf8mb4"_

## Fixtures
**email** : **password**

`test@gmail.com` : `test`

`marius@gmail.com` : `marius`

`evan@gmail.com` : `evan`


