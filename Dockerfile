FROM php:7.4-fpm

RUN apt-get update && apt-get install -y cron
WORKDIR /var/eng-blogs
COPY docker/cronjobs /etc/crontabs/root
