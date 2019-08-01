FROM php:7.3.7-fpm-alpine3.10

WORKDIR /var/www
RUN rm -rf /var/www/html
COPY . /var/www
RUN ls -s public html


RUN docker-php-ext-install pdo pdo_mysql

EXPOSE 9000
ENTRYPOINT ["php-fpm"]