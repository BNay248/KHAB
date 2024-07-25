FROM php:7.2-apache
COPY . /var/www/html
WORKDIR /var/www/html
RUN chown www-data:www-data ./users
EXPOSE 80
