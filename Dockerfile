FROM php:7.0-apache

RUN a2enmod rewrite

RUN docker-php-ext-install mysqli

COPY . .
