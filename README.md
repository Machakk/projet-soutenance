# DEV - NATION

## Base de données
- dans .env
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/devnation"
```

- sur le terminal
```
php bin/console doctrine:database:create
```

- Create entities
```
php bin/console make:entity
```