FROM alpine:3.16

RUN apk update \
  && apk upgrade \
  && apk add php8 php8-fileinfo php8-simplexml php8-tokenizer composer nodejs-current npm

ENV PHP_INI_DIR /etc/php8

RUN printf "# composer php cli ini settings\n\
  date.timezone=UTC\n\
  memory_limit=-1\n\
  " > $PHP_INI_DIR/php-cli.ini

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp

WORKDIR /root/app
