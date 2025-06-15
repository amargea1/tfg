FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libonig-dev libzip-dev zip libxml2-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia el código fuente
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Establece permisos
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/vendor

# Configura Apache
COPY ./docker/apache.conf /etc/apache2/sites-enabled/000-default.conf
