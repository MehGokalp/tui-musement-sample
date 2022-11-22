FROM php:8.1.12-cli-alpine
# install extensions

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.1.1 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps \

# infinitive loop to keep container aliave
CMD ["php", "-r", "while(true){}"]