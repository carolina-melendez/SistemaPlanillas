FROM php:8.2-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo pdo_mysql

# Configurar Apache
RUN a2enmod rewrite

# Configurar el nombre del servidor en Apache
RUN echo "ServerName sistemaplanillas.onrender.com" >> /etc/apache2/apache2.conf

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
