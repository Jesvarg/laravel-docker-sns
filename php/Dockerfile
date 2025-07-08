FROM php:8.2-apache

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar configuración Apache para Laravel
COPY php/apache-laravel.conf /etc/apache2/sites-available/000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Montar el código con volumen (no necesitas copiar el código aquí)

# Asignar permisos (estos comandos los puedes correr en el contenedor)
# RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# No copies el código porque lo montas con volumen
