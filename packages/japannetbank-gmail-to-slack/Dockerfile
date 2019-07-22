FROM php:7.1-alpine

RUN set -eux \
    && apk update \
    && apk add curl \
    && curl -L --insecure https://github.com/odise/go-cron/releases/download/v0.0.7/go-cron-linux.gz | zcat > /usr/local/bin/go-cron \
    && chmod u+x /usr/local/bin/go-cron \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /app

ENV GMAIL_ACCOUNT ""
ENV SLACK_WEBHOOK_URL ""
ENV GOOGLE_APPLICATION_CREDENTIALS "/app/credentials.json"
