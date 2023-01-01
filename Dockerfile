FROM richarvey/nginx-php-fpm:1.9.0

ARG appEnv=prod
ENV APP_ENV=$appEnv
ARG TZ="Europe/Paris"

RUN cat /start.sh | head -n -3 > /start-command.sh \
  && printf "cd /var/www/html/ \nbin/console \"\$@\" \n" >> /start-command.sh \
  && chmod +x /start-command.sh

RUN set -xe \
  && echo $TZ > /etc/TZ \
  && ln -sf /usr/share/zoneinfo/$TZ /etc/localtime
  
RUN apk add --no-cache --virtual .build-deps \
    g++ make autoconf yaml-dev


RUN wget https://getcomposer.org/installer -O composer-setup.php \
  && php ./composer-setup.php  --install-dir=/usr/local/bin \
  && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY . /var/www/html
RUN rm /var/www/html/Dockerfile
#COPY ./nginx-site.conf /etc/supervisor/conf.d/

WORKDIR /var/www/html

ENV SKIP_CHOWN=true
#ENV RUN_SCRIPTS=1
ENV SKIP_COMPOSER=true
RUN composer install --no-interaction \
    && composer clearcache -n