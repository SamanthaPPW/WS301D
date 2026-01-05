# Utiliser du CSS et du JS dans Symfony

Les fichiers CSS et JS sont à placer dans le dossier `assets/` à la racine du projet.

Exemple Twig:

```
{% block javascripts %}
    {% block importmap %}{{ importmap('app') }}{% endblock %}
{% endblock %}
```

app est un fichier (app.js) se trouvant dans le dossier assets/.

<hr>

Pour intégrer des images :
```
<img src="{{ asset('images/product.jpg') }}" alt="Product">
```
product.jpg se trouve dans le dossier assets/images/.

<hr>

Pour compiler du sass vers css :

```sass assets/scss/app.scss assets/css/app.css```

à tester si vous avez bien sass d'installé, sinon dans le container symfony-web (dans php storm, pas dans le terminal):

```
apt install npm
npm install -g sass
```
(Je préviens, npm va mettre plein d'erreurs mais c'est ok)

IMPORTANT : On compile un fichier à l'autre, pas en dossier comme on a vu en SCSS

<hr>

Normalement, on a pas besoin de déclarer d'autres fichiers css, mais sinon c'est dans assets/app.js

Dans base twig faut retirer le stylesheet car on l'importe dans le fichier js, donc le block ne sert à rien :) 

<hr>
<hr>

# Importer sur son docker

Il faut se connecter au container et se placer dans /var/www et git clone : 

```
git clone https://github.com/SamanthaPPW/WS301D.git
```

Ensuite, il faut aller dans /etc/apache2/sites-enabled, copier le fichier symfony en sae301 ou du nom de vous voulez
```
cp 001-symfony.conf 001-sae301.conf
```
puis éditer le fichier : 

```
<VirtualHost *:80>
ServerName sae301.mmi-troyes.fr
DocumentRoot /var/www/WS301D/public
DirectoryIndex index.php

<Directory /var/www/WS301D/public>
# Support des fichiers htaccess
AllowOverride All

<IfModule mod_rewrite.c>
    RewriteEngine On

    RewriteCond %{REQUEST_URI}::$0 ^(/.+)/(.*)::\2$
    RewriteRule .* - [E=BASE:%1]

    RewriteCond %{HTTP:Authorization} .+
    RewriteRule ^ - [E=HTTP_AUTHORIZATION:%0]

    RewriteCond %{ENV:REDIRECT_STATUS} =""
    RewriteRule ^index\.php(?:/(.*)|$) %{ENV:BASE}/$1 [R=301,L]

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ %{ENV:BASE}/index.php [L]

</IfModule>

</Directory>

ErrorLog ${APACHE_LOG_DIR}/symfony_error.log
CustomLog ${APACHE_LOG_DIR}/symfony_access.log combined


</VirtualHost>
```
Il faut recharger apache, et normalement c'est ok (a reconfirmer)

Nouveauté, Des fichiers ne sont pas dans le git, il faut faire un composer install dans le dossier du projet sur le docker pour les récupérer.
