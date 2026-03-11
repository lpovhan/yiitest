FROM php:8.4-fpm

ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y git unzip libzip-dev libpng-dev libonig-dev
RUN docker-php-ext-install pdo pdo_mysql mbstring zip gd

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

WORKDIR /var/www

COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN git config --system --add safe.directory /var/www

USER root

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]