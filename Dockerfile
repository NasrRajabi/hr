
FROM php:8.2-alpine

RUN apk update
RUN apk add git
RUN apk add curl 

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install  pdo pdo_pgsql pgsql


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer 

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions sockets
RUN install-php-extensions mbstring
RUN install-php-extensions gd
RUN install-php-extensions dom
RUN install-php-extensions xdebug


RUN docker-php-ext-enable xdebug