FROM php:8.0-cli

# install swoole
RUN apt-get update && \
    apt-get install -y libssl-dev
RUN docker-php-ext-install sockets
RUN printf "yes\nyes\nyes\nyes\nno\nno" | pecl install swoole
RUN docker-php-ext-enable swoole

# install composer
RUN apt-get update && \
    apt-get install -y git zip
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN chmod 755 /usr/bin/composer

# system setup
WORKDIR /usr/lib/small-logger

# run tests
COPY . /usr/lib/small-logger
RUN COMPOSER_ALLOW_SUPERUSER=1 composer update
RUN ./vendor/bin/phpunit --testdox tests

ENTRYPOINT sleep infinity