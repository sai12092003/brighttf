FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring gd \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public_html#' /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public_html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . .

RUN mkdir -p storage/logs public_html/uploads \
    && chown -R www-data:www-data storage public_html/uploads \
    && chmod -R 755 storage public_html/uploads \
    && rm -rf tailwind-src .git

EXPOSE 80
