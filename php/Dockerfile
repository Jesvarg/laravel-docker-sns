# Usa la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Habilita el módulo mod_rewrite de Apache
RUN a2enmod rewrite

# Instala extensiones de PostgreSQL (opcional si no lo usas)
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instala extensión MySQLi para conectar con MySQL
RUN docker-php-ext-install mysqli

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido del directorio `html/` local al contenedor
COPY html/ .

# Opcional: Establece permisos si es necesario
# RUN chown -R www-data:www-data /var/www/html
