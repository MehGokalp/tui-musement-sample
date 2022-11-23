Author: Mehmet Gökalp

Email: mehmet.gokalp@jagaad.com

Consulting Company: Jagaad

This project allows you to fetch cities from musement api and shows you each of the cities forecasts.

## Installment

#### Configure your .env files

Create a file named `.env.local`, copy content of the `.env` file and paste into it and configure any needed parameter.

#### Docker

> docker compose up

connect to `php` container using your terminal

sample connect command;

> docker container exec -it tui-musement-mg-sample-php-1 /bin/sh

then

> cd /var/www/html && bin/composer install

will be enough for set up.

## Weather Report of Musement Cities

To get forecast reports run this command inside the `php` container.

> php bin/console app:forecast

## Tests

To run tests

> php bin/phpunit