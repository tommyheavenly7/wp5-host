#!/bin/bash

if [[ ! -d "./docker" ]]; then
    echo "Failed to find docker settings."
    exit 1
fi
if [[ -z "$1" ]]; then
  TARGET="ALL"
else
  TARGET="$1"
fi

if [[ ${TARGET} = 'php' || 'ALL' ]]; then
    # php-fpm
    printf "FROM php:7.4-fpm-alpine\n\n" > docker/php/Dockerfile && \
    cat src/layers/php/apk-add.txt >> docker/php/Dockerfile && \
    cat src/layers/php/ssmtp.txt >> docker/php/Dockerfile && \
    cat src/layers/php/extensions.txt >> docker/php/Dockerfile && \
    cat src/layers/php/ini-settings.txt >> docker/php/Dockerfile
    # php-cli
    printf "FROM php:7.4-cli-alpine\n\n" > docker/php-cli/Dockerfile && \
    cat src/layers/php/apk-add.txt >> docker/php-cli/Dockerfile && \
    cat src/layers/php/ssmtp.txt >> docker/php-cli/Dockerfile && \
    cat src/layers/php/extensions.txt >> docker/php-cli/Dockerfile && \
    cat src/layers/php/ini-settings.txt >> docker/php-cli/Dockerfile && \
    cat src/layers/php/composer.txt >> docker/php-cli/Dockerfile
fi