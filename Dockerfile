FROM php:7.2-apache
COPY . /var/www/html
WORKDIR /var/www/html
RUN chown www-data:www-data ./users
RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get update
RUN dpkg --get-selections gnupg
RUN apt-get install -y gnupg
RUN apt-get update
RUN apt-get install -y wget
RUN apt-get update
RUN wget -qO - https://www.mongodb.org/static/pgp/server-6.0.asc | apt-key add -
RUN echo "deb http://repo.mongodb.org/apt/debian buster/mongodb-org/6.0 main" | tee /etc/apt/sources.list.d/mongodb-org-6.0.list
RUN apt-get update
RUN apt-get install -y mongodb-org
EXPOSE 80
