FROM php:8.0-fpm

WORKDIR /home/docker

RUN apt update \
    && apt install -y \
        git \
        libpq-dev \
        libzip-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install -j$(nproc) \
        pdo_pgsql \
        zip

RUN docker-php-source delete

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer \
    && mkdir -p /home/composer \
    && chown -R 1000 /home/composer \
    && chmod -R 777 /home/composer

COPY ./docker/engine/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY ./docker/engine/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
