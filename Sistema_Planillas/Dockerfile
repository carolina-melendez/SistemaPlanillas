FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Configurar Apache
RUN a2enmod rewrite

# Configurar el nombre del servidor en Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Crear directorio de logs
RUN mkdir -p /var/log/apache2

# Copiar los archivos del proyecto
COPY . /var/www/html

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Exponer el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]
