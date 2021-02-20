# DEV - NATION

## Design

### Couleurs

Principale: #184D4D
Secondaire: #41826A
Autre: a definir

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
