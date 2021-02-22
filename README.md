# DEV - NATION

## Design

### Couleurs

Principale: #184D4D
Secondaire: #41826A
paragraphe: #4e4e4e
Autre: a definir

### Polices

Titre: font-family: 'Sawarabi Gothic', sans-serif;
Sous-titre: font-family: 'Noto Sans', sans-serif;
Paragraphe: font-family: 'KoHo', sans-serif;

## Base de données

### Pour recuperer la base de données

- git pull origin master
- composer update

- dans .env verifier la ligne suivants

```
DATABASE_URL="mysql://root:@127.0.0.1:3306/devnation"
```

- sur le terminal

```
php bin/console doctrine:database:create
```

- puis

```
php bin/console doctrine:migrations:migrate
```

#####

- Create entities

```
users, skills, articles,  PostForum, metiers,
```
