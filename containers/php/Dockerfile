FROM php:8.2.27-fpm

# INSTALL DEPENDENCIES
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev && \
    docker-php-ext-install zip

# INSTALL COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'.PHP_EOL; } else { echo 'Installer corrupt'.PHP_EOL; unlink('composer-setup.php'); exit(1); }" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer


COPY ./scripts/startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

WORKDIR /usr/share/nginx/html

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/startup.sh"]
CMD ["php-fpm"]