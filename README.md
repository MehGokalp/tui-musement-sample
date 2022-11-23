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

> docker container exec -it tui-musement-sample-php-1 /bin/sh

then

> cd /var/www/html && bin/composer install

will be enough for set up. (keeping composer.phar inside bin folder increases project size, but it makes life much, much easier)

## Weather Report of Musement Cities

To get forecast reports run this command inside the `php` container.

> php bin/console app:forecast

## Tests

To run tests

> php bin/phpunit

## Development Strategies

This project is using PHP 8.1 and Symfony 6.* (Stable release)

1- SOLID, DRY, KISS principles are applied to code base

2- Common programming patterns are applied iterator, factory, decorator, facade

3- Php 8.1 features are used, Enum, constructor property promotion, attributes and more...

4- declare(strict_types=1) used for strict type hints

5- https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html has implemented

6- ADR (action, domain, responder) system design applied

7- PhpStan has installed to keep every file same structured

### Musement and WeatherApi implementation details
1- Under `src/Musement/Endpoint` we have our implemented endpoints (see `src/Musement/Endpoint/City`).
If we'd like to implement another endpoint we just need to create another file, and we can implement other
endpoints too.

2- We have interfaces for both different apis, they can look same, but they are not. It's because of SOLID, mostly interface segregation
Many APIs can have their own logic. Some of them can have authentication, some of them have other requirements.
It's better to split them and here we applied this methodology.

3- We have layers on this implementation

3.1- API clients (ex: `src/Api/Musement/Client.php`)

Responsible for common operations between endpoints. Authentication etc. Also, Clients are supporting Caching responses (see: \Symfony\Component\HttpClient\CachingHttpClient).

3.2- Endpoint definitions (ex: `src/Api/Musement/Endpoint/EndpointEnum.php`)

Responsible for static Endpoint definitions. Path, methods etc.

3.3- Response Validators (ex: `src/Api/Musement/Endpoint/City/CityResponseValidator.php`)

Responsible for validating the responses.

3.4- Response Parsers (ex: `src/Api/Musement/Endpoint/City/CityResponseParser.php`)

Responsible for parsing raw response into DTOs.

3.5- Responses (ex: `src/Api/Musement/Endpoint/City/Response/CityResponse.php`)

Keeps parsed response inside.

## Forecast API

See `src/Resources/openapi/forecast.yaml` for open api definitions. Also, you can open `src/Resources/openapi/index.html`
for UI.

There are 5 different schemas exists for BULK operations. Location and Forecast schema is defined for single model
definition but as you can see `Bulk form of forecast` is using array of Forecasts to `PUT` and `POST` forecasts.

## About TODOS
I put some TODOS to show we can extend the implementation. I did not leave any TODO by mistake.