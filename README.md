# [Clairveillance Backend](https://github.com/Clairveillance/clairveillance-backend)

This project was generated with [Laravel Installer](https://github.com/laravel/installer) version 4.2.8.

#### Make New Migrations

```
php artisan make:migration <name> --path=src/Infrastructure/database/migrations/v1
```

#### Run Migrations (with seeders)

```
php artisan migrate:fresh --path=src/Infrastructure/database/migrations/v1 --seed
```

```
php artisan migrate:refresh --path=src/Infrastructure/database/migrations/v1 --seed
```

#### Generate Php Documentation with [Php Documentor](https://www.phpdoc.org/)

```
phpDocumentor -d src/ -t src/Infrastructure/storage/docs/phpDocumentor
```

#### Generate Api Documentation with [Swagger](https://github.com/DarkaOnLine/L5-Swagger)

```
php artisan l5-swagger:generate
```

#### [PHP CS Fixer](https://github.com/eduarguz/shift-php-cs)

```
./vendor/bin/php-cs-fixer fix
```

_PHP needs to be a minimum version of PHP 7.2.5 and maximum version of PHP 8.0.\*._

```
PHP_CS_FIXER_IGNORE_ENV=1 ./vendor/bin/php-cs-fixer fix
```

_Running the above command will ignore environment requirements._

#### [PHP Lint](https://github.com/overtrue/phplint)

```
./vendor/bin/phplint
```

#### [EER Diagram](https://github.com/Clairveillance/clairveillance-backend/blob/master/assets/img/EER_diagram_003.png)

![EER Diagram](assets/img/EER_diagram_003.png "EER Diagram")

#### [API Response](https://github.com/Clairveillance/clairveillance-backend/blob/master/assets/img/api_users_0043.png)

![API Response](assets/img/api_users_004.png "API Response Overview")

#### [Swagger](https://github.com/Clairveillance/clairveillance-backend/blob/master/assets/img/swagger_001.png)

![Swagger](assets/img/swagger_001.png "Swagger Overview")

#### [Php Documentor](https://github.com/Clairveillance/clairveillance-backend/blob/master/assets/img/php_documentor_002.png)

![Php Documentor](assets/img/php_documentor_002.png "Php Documentor Overview")
