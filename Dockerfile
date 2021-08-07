FROM php:7.4-apache

# Variáveis de ambiente do Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/log/apache2

#Instala dependências
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions pdo pdo_mysql gd zip exif

# Instala dependências de extensões, nano e supervisor
RUN apt-get update && apt-get install git libzip-dev nano supervisor -y

# Cria o diretório de logs para o Supervisor
RUN mkdir /var/log/webhook

# Copia o entreypoint
COPY ./entrypoint /var/www/entrypoint

# Adiciona permissão de execução para o Entrypoint
RUN chmod +x /var/www/entrypoint

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Seta o document root configurado anteriormente nas variáveis de ambiente
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Diretorio Raiz
WORKDIR /var/www/html

# Disabled default conf apache
RUN a2dissite 000-default.conf

# Copy my conf
COPY ./httpd/default.conf /etc/apache2/sites-available/project-irroba.conf

# Monta a conf
RUN a2ensite project-irroba.conf

# Ativa o mod_rewrite do Apache
RUN a2enmod rewrite

# Restart apache2
RUN service apache2 restart

# Informa o Entrypoint
ENTRYPOINT [ "/var/www/entrypoint" ]