FROM php:7.4-apache
COPY create-json.php /var/www/html
COPY create-user.php /var/www/html
COPY index.html /var/www/html
COPY login.php /var/www/html
COPY pullRecipe.php /var/www/html
COPY share.php /var/www/html
WORKDIR /var/www/html
RUN apt-get update && \
    apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    apt-get install -y git && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \   
    composer init --name="khab/khab" --description="desc" --require="mongodb/mongodb:^1.0" --no-interaction && \
    composer install
EXPOSE 80
