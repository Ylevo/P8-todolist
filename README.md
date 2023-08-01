# P8 - ToDo & Co
ToDo & Co project built with Symfony
## Installation
This project uses composer and docker.

1. Clone the repository.
2. Run `docker-compose up -d` to install & initiate the main mysql database.
3. Run `composer install` to install the dependencies.
4. Launch symfony server with `symfony serve -d`

You can use the 'Admin' and 'Test User' accounts for testing. Both have 'password' as password.

## Using PHPUnit

1. Create the test database `symfony console doctrine:database:create --env=test`
2. Generate doctrine's migration `symfony console make:migration --env=test`
3. Create the database's tables `symfony console doctrine:migrations:migrate --env=test`
4. Populate the database using the fixtures `symfony console doctrine:fixtures:load --env=test`
5. Launch the tests `vendor/bin/phpunit`
6. Generate the test coverage `vendor/bin/phpunit --coverage-html public/test-coverage`
7. You can then find it in ***public/test-coverage***

## How to contribute

To report a bug, suggest a new feature or anything alike, open a new issue in the issues tab after checking that a similar issue doesn't exist yet. Make sure to check in the closed issues as well.
If you're looking to contribute to the code of this project directly :

1. Fork this repo.
2. Create a new branch and work on it.
3. Create a new pull request linking to the issue you worked on.

The request may even be accepted some day but don't hold your breath.

A few pointers :

- Code must be clear and readable
- Test your code (using PHPUnit for example)
- You may use SymfonyInsight to check code quality and detect security vulnerabilities
