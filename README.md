# Projet Théâtre
## INF403 - uga

Le site détecte automatiquement si vous êtes en local ou non.

* Si vous êtes en local, il va gérer la base de données avec PDO.
* Si vous êtes en ligne, il va gérer la base de données avec OCI.

* Il vous suffit de remplir le champ `Database` dans `www/_conf/config.ini` :
    * host
    * port
    * service_name
    * username
    * password
    * type='oci' (ne pas toucher)

Toutes les pages sont dans `views/`.

La gestion base de données / configuration est dans `www/_conf/`.

Le css, js, certains modules php sont dans `www/theme/`.

La base (template) html est dans `www/theme/template.php`.

Pour accèder au site: `mon/url/ProjetTheatre/www[/index.php]`