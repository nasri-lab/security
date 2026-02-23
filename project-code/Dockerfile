# Utilisation d'une image PHP officielle avec Apache
FROM php:8.2-apache

# Installation des extensions nécessaires pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# On active le module de réécriture d'Apache (souvent utile en PHP)
RUN a2enmod rewrite

# Copie du code source dans le conteneur
COPY ./src /var/www/html/

# On s'assure que les permissions sont correctes
RUN chown -R www-data:www-data /var/www/html