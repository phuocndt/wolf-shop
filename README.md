# Wolf Shop

## Getting start

1. Start the docker compose to pulling all dependencies
- Open the `docker` folder with Terminal
- Run the command: `docker compose up -d`
2. Go to project folder
- Edit the Database information in `.env` file
- Run Laravel artisan serve: `php artisan serve`
- Run Laravel artisan migrate to migrate the database: `php artisan migrate`
- Check the current APIs: `php artisan route:list`<br>
    GET|HEAD   / ........................<br>
    POST       api/item ................. API\ItemController@createItem<br>
    GET|HEAD   api/items ................ API\ItemController@index<br>
    POST       api/login ................ API\Auth\AuthController@login<br>
    POST       api/register ............. API\Auth\AuthController@register<br>
    POST       api/upload-image ......... API\ImageUploadController@upload<br>
    GET|HEAD   api/user .................<br>
    GET|HEAD   sanctum/csrf-cookie ...... sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show<br>
    GET|HEAD   up .......................<br>
- Import data to the database: `php artisan app:import-items`

## Tech stacks

- Docker images:
    - `nginx`: nginx:1.25-alpine
    - `php`: php:8.3.4-fpm-alpine3.19
    - `mysql`: mysql:5
    - `redis`: bitnami/redis:latest
- Framework: Laravel 11.9
- Unit testing: phpunit 11.0.1
- Easy Coding Standard: 12.3

## Folders structure

- `docs`
    - `thunder-colection` - the API colection
- `docker` - contains configuration for all docker images:
    - `mysql` - this folder has a configuration of MySQL container
    - `nginx` - this folder has a configuration of Nginx container
    - `php` - this folder has a configuration of PHP container
    - `redis` - this folder has a configuration of Redis container
    - `docker-compose.yml` - docker compose setup file
- `app` - The app directory contains the core code of your application. We'll explore this directory in more detail soon; however, almost all of the classes in your application will be in this directory.
    - `Console` - The Console directory contains all of the custom Artisan commands for your application. These commands may be generated using the make:command command.
    - `Http` - The Http directory contains your controllers, middleware, and form requests. Almost all of the logic to handle requests entering your application will be placed in this directory.
    - `Models` - The Models directory contains all of your Eloquent model classes. The Eloquent ORM included with Laravel provides a beautiful, simple ActiveRecord implementation for working with your database. Each database table has a corresponding "Model" which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.
    - `Providers` - The Providers directory contains all of the service providers for your application. Service providers bootstrap your application by binding services in the service container, registering events, or performing any other tasks to prepare your application for incoming requests.
    - `Services` - service files.
- `bootstrap` - The bootstrap directory contains the app.php file which bootstraps the framework. This directory also houses a cache directory which contains framework generated files for performance optimization such as the route and services cache files.
- `config` - The config directory, as the name implies, contains all of your application's configuration files. It's a great idea to read through all of these files and familiarize yourself with all of the options available to you.
- `database` - The database directory contains your database migrations, model factories, and seeds. If you wish, you may also use this directory to hold an SQLite database.
- `public` - The public directory contains the index.php file, which is the entry point for all requests entering your application and configures autoloading. This directory also houses your assets such as images, JavaScript, and CSS.
- `resources` - The resources directory contains your views as well as your raw, un-compiled assets such as CSS or JavaScript.
- `routes` - The routes directory contains all of the route definitions for your application. By default, two route files are included with Laravel: web.php and console.php.
- `storage` - The storage directory contains your logs, compiled Blade templates, file based sessions, file caches, and other files generated by the framework. This directory is segregated into app, framework, and logs directories. The app directory may be used to store any files generated by your application. The framework directory is used to store framework generated files and caches. Finally, the logs directory contains your application's log files.
- `vendor` - The vendor directory contains your Composer dependencies.
- `tests` - The tests directory contains your automated tests. Example Pest or PHPUnit unit tests and feature tests are provided out of the box. Each test class should be suffixed with the word Test. You may run your tests using the /vendor/bin/pest or /vendor/bin/phpunit commands. Or, if you would like a more detailed and beautiful representation of your test results, you may run your tests using the php artisan test Artisan command.
- `composer.json` - manage dependencies
- `phpunit.xml` - configuration of PHPUnit
- `ecs.php` - configuration of Easy Coding Standard
- `.env` environment variable file

## Testing
### Unit Test
- Run the command: `php artisan test`

## Coding standard
- We using easy-coding-standard to check and fix the coding issue. Reference: https://github.com/easy-coding-standard/easy-coding-standard
    - To check the issue: `./vendor/bin/ecs check`
    - To fix the issue: `./vendor/bin/ecs --fix`
