FROM php:8.2-fpm-buster

ENV ACCEPT_EULA=Y

RUN apt-get update && apt-get install -y \
    gnupg2 \
    git \
    unzip \
    libxml2-dev \
    libzip-dev \
    libc-client-dev \
    libkrb5-dev \
    xsltproc

RUN apt-get update \
    && curl -s https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl -s https://packages.microsoft.com/config/debian/9/prod.list \
        > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get install -y --no-install-recommends \
        locales \
        apt-transport-https \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && locale-gen \
    && apt-get update \
    && apt-get -y --no-install-recommends install \
        unixodbc-dev \
        msodbcsql17

RUN apt-get update --allow-releaseinfo-change && apt-get install -y \
    procps \
    libonig-dev

#configure xdebug
RUN pecl install xdebug-3.1.6; \
    docker-php-ext-enable xdebug; \
        echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
        echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

RUN docker-php-ext-install \
    mbstring \
    pdo_mysql \
    soap \
    bcmath \
    sockets \
    pcntl

RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APP_ENV=dev
ENV APP_PATH=/app

WORKDIR ${APP_PATH}

COPY . ./

VOLUME ${APP_PATH}

EXPOSE 9000
