# Escolher a imagem base do PHP com Apache
FROM php:8.1-apache

# Instalar extensões PHP necessárias, incluindo GD e Fileinfo
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd fileinfo

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o projeto Laravel para o diretório padrão do Apache
COPY . /var/www/html

# Definir as permissões para o diretório de cache e logs do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta 80 para acesso
EXPOSE 80

# Iniciar o Apache no container
CMD ["apache2-foreground"]
