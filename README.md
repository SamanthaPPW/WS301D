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

à tester si vous avez bien sass d'installé, sinon dans le container symfony-web :

IMPORTANT : On compile un fichier à l'autre, pas en dossier comme on a vu en SCSS

```
apt install npm
npm install -g sass
```

<hr>

Normalement, on a pas besoin de déclarer d'autres fichiers css, mais sinon c'est dans assets/app.js

Dans base twig faut retirer le stylesheet car on l'importe dans le fichier js, donc le block ne sert à rien :) 
