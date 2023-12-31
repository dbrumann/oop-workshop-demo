# OOP & Design Patterns Workshop

Demo App for the OOP & Design Patterns workshop at
Symfony Live Berlin 2023.

## Installation instructions

1. Clone the repository:
    ```bash
    git clone https://github.com/dbrumann/oop-workshop-demo.git
    ```
2. Install the dependencies:
    ```bash
    composer install
    ```
3. Start dockerized environment (optional)
    ```bash
    docker compose up
    ```
4. Set up database:
    ```bash
    # docker compose exec app bash
    php bin/console doctrine:schema:update --force
    php bin/console doctrine:fixtures:load
    ```
5. Check if website is available: https://localhost

#### Testing

Some tests require a database. By default, an SQLite database is used. You can change the configuration in `.env.test`.

Before you run the tests, you have to set up the test database. You can use the commands from step 4, but add the option
`--env=test`. In other words:

```bash
# docker compose exec app bash
php bin/console doctrine:schema:update --env=test --force
php bin/console doctrine:fixtures:load --env=test
```

You should be able to run the tests and, if you did not change the code, all tests should be green:

```bash
php vendor/bin/phpunit
```

Loading the fixtures will purge the database, i.e. reset it to the default state. I recommend doing it after each task
to ensure your tests don't rely on the current (altered) state.

### Known Issues

#### I don't have docker installed

Instead of setting up the dockerized environment, you can also switch the database to whatever you have available.
SQLite is a good choice for local development: `DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"`

You should have PHP and the [Symfony CLI](https://symfony.com/download) installed locally. If so, run the commands
from step 4 and then start the [local development server with the CLI](https://symfony.com/doc/current/setup/symfony_server.html):

```bash
symfony server:start
```

You should then be able to access the page at http://localhost:8000 or use the command: `symfony open:local`

#### I can't work with FrankenPHP as app container

No problem. Feel free to replace the setup with something more traditional. You can either just keep the database
and use the local webserver (recommended) or replace the container with a combined PHP/Apache

## Tasks

### Task 1: SOLID principles - Dependency Inversion

The Admin-ProductController (`src/Controller/Admin/ProductController.php`) does not adhere to the Dependency Inversion
principle.

- Remove container-usage in the actions
- (optional) Do not rely on the AbstractController
- (optional) Change controller to be a single action controller

### Task 2: DDD and Object Calisthenics

The Product entity (`src/Entity/Product.php`) is an anemic model. Instead, we want to have a rich model, meaning:

 - Replace setters with named methods, e.g. `setName` to `rename`
 - Ensure the entity is always valid (pass arguments to the constructor)
 - Encapsulate scalar values into objects, i.e. change $price from integer to a Price-object with amount and currency

Note: When making the entity into a rich model, the form for creating a product will likely no longer work.
If you have time, fix this as well.
