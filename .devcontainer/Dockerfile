FROM alpine:3.16

RUN apk update \
  && apk add --no-cache git nano openssh-client parallel \
  && apk add --no-cache php8 php8-dom php8-fileinfo php8-simplexml php8-tokenizer php8-xml php8-xmlwriter composer \
  && apk add --no-cache nodejs-current npm

ENV PHP_INI_DIR /etc/php8

RUN printf "# composer php cli ini settings\n\
  date.timezone=UTC\n\
  memory_limit=-1\n\
  " > $PHP_INI_DIR/php-cli.ini

RUN echo 'will cite' | parallel --citation 1> /dev/null 2> /dev/null || exit 0

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
