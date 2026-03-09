# Utilisation d'une image PHP officielle avec Apache
FROM php:8.2-apache

# --- DEPENDANCES SYSTEME ---
# Installation des extensions nécessaires pour MySQL
# [DÉCOMMENTER LES 3 LIGNES CI-DESSOUS POUR LE SUPPORT LDAP]
# RUN apt-get update && apt-get install -y \
#    libldap2-dev \
#     && rm -rf /var/lib/apt/lists/*

# Installation des extensions nécessaires pour MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# [DÉCOMMENTER LES 2 LIGNES CI-DESSOUS POUR ACTIVER LDAP DANS PHP]
# RUN docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ && \
#     docker-php-ext-install ldap

# On active le module de réécriture d'Apache (souvent utile en PHP)
RUN a2enmod rewrite

# Copie du code source dans le conteneur
COPY ./src /var/www/html/

# On s'assure que les permissions sont correctes
RUN chown -R www-data:www-data /var/www/html