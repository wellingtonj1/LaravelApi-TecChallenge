# Use a imagem oficial do PHP com Apache
FROM php:8.1-apache

# install zip unzip 
RUN apt-get update && apt-get install -y zip unzip

# Instale as extensões necessárias do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurações do Apache
RUN a2enmod rewrite
RUN service apache2 restart

# Configuração do diretório de trabalho
WORKDIR /var/www/html/src

# Copie os arquivos do projeto para o contêiner
COPY . /var/www/html

# Configure as permissões do Apache
RUN chown -R www-data:www-data /var/www/html/src/storage
RUN chmod -R 775 /var/www/html/src

# Expor a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]