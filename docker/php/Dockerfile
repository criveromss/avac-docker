FROM php:8.3-fpm-alpine

# Installer les extensions PHP requises
RUN apk add --no-cache \
    bash \
    git \
    zip \
    unzip \
    curl \
    libpng-dev \
    oniguruma-dev \
    jpegoptim optipng pngquant gifsicle \
    && docker-php-ext-install pdo pdo_mysql

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet Symfony
COPY . /var/www/html

# Définir les permissions correctes
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer les dépendances PHP de Symfony
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
