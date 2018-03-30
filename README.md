# mangatech
Projet symfony

1. git clone https://github.com/tanmba/mangatech.git

2. Se mettre dans le dossier cloner et installer composer
    - Sur mac : `$ curl -sS https://getcomposer.org/installer | php`
    - Sur windows : se rendre sur `https://getcomposer.org/download/` et télécharger composer

3. Faire `$ composer install` pour mettre à jour les dépendances.

4. Création de la base de données avec comme nom `mangatech`.

5. Dans le fichier `.env` à la ligne 23 configurer les accès à la base données.
    Remplacer `db_user` par votre identifiant.
    Remplacer `db_password` par le mot de passe de votre base de données.
    Remplacer `db_name` par mangatech. 
    
6. Faire `$ php bin/console doctrine:schema:update --force` pour mettre à jour votre base de données.

7. Faire `$ php bin/console doctrine:fixtures:load` pour créer un administrateur.
    Pour se connecter en tant qu'administrateur :
    `username : admin` 
    `password : admin`

8. Faire `$ php bin/console server:start` pour lancer les serveurs.

9. Dans le fichier `.env` remplacer à la ligne 16 `MAILER_URL=null://localhost` par `MAILER_URL=gmail://projetmangatech:mangatech2018@localhost`


Bon partage de mangas sur Mangatech :)

