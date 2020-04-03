# Projet Théâtre
## INF403 - uga

Vous devez créer un fichier config.ini dans `www/_conf/`, et remplir les infos concernant la base de données.

dans www/_conf/config.ini, pour le champ `database.type`, veuillez mettre :
* Si vous utilisez PDO: `pdo`
* Si vous utilisez OCI: `oci`

Cela permettra d'utiliser le fichier `pdo_database.php` ou `oci_database.php` suivant ce que vous avez mis.

Le fichier `www/_conf/model.config.ini` sert uniquement au dev local. Pour l'utiliser, il faut changer le `define('DB_TYPE', '')` en `define('DB_TYPE', 'model.')` dans `www/index.php`

Toutes les pages sont dans `views/`.

Tous ce qui est serveur / template dans `www/`.