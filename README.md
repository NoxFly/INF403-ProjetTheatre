# Projet Théâtre
## INF403 - uga

Le site détecte automatiquement si vous êtes en local ou non.

Il vous suffit de remplir le champ `Database` dans `www/_conf/[local.]config.ini` suivant si vous êtes en local ou non.

La base de donnée ne se charge pas en local, pour modifier ça, vous devez changer la variable `$local` dans `www/index.php` sur `true`.

Toutes les pages sont dans `views/`.

La gestion base de données / configuration est dans `www/_conf/`.

Le css, js, certains modules php sont dans `www/theme/`.

La base (template) html est dans `www/theme/template.php`.

Pour accèder au site: `mon/url/ProjetTheatre/www[/index.php]`