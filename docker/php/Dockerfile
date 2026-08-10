FROM php:8.4-fpm-alpine
COPY ./php.ini /usr/local/etc/php/php.ini
RUN apk add --no-cache \
        gmp-dev \
        $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install gmp \
    && apk del $PHPIZE_DEPS
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer