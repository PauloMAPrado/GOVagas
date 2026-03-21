FROM php:8.3-apache

ARG UID=1000
ARG GID=1000

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libicu-dev \
    libxml2-dev default-mysql-client curl \
  && docker-php-ext-install pdo_mysql mbstring zip intl \
  && a2enmod rewrite headers \
  && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
  && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN groupadd -g ${GID} appgroup \
  && useradd -u ${UID} -g ${GID} -m appuser

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/writable \
  && chown -R appuser:appgroup /var/www/html

USER appuser