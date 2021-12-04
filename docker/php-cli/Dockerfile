FROM php:7.4-cli-alpine

RUN apk --no-cache add \
    "autoconf>=2.69-r2" \
    "automake>=1.16.2-r0" \
    "brotli-libs>=1.0.9-r1" \
    "build-base>=0.5-r2" \
    "curl>=7.79.1-r0" \
    "ffmpeg>=4.4.1-r0" \
    "g++>=9.3.0-r2" \
    "gcc>=9.3.0-r2" \
    "ghostscript>=9.52-r0" \
    "git>=2.26.2-r0" \
    "gnutls>=3.6.15-r0" \
    "groff>=1.22.4-r1" \
    "icu-dev>=67.1-r0" \
    "imagemagick-dev>=7.0.11.14-r0" \
    "imagemagick>=7.0.11.14-r0" \
    "lcms2-dev>=2.9-r1" \
    "less>=551-r0" \
    "libgit2-dev>=1.0.0-r0" \
    "libjpeg-turbo>=2.0.5-r0" \
    "libjpeg>=9d-r0" \
    "libpng-dev>=1.6.37-r1" \
    "libssh>=0.9.4-r1" \
    "libtool>=2.4.6-r7" \
    "libwebp-dev>=1.1.0-r0" \
    "libx11>=1.6.12-r0" \
    "libxml2>=2.9.10-r5" \
    "make>=4.3-r0" \
    "musl-utils>=1.2.2_pre2-r0" \
    "mysql-client>=10.5.10-r0" \
    "nasm>=2.14.02-r0" \
    "oniguruma>=6.9.5-r2" \
    "py-pip>=20.1.1-r0" \
    "python3-dev>=3.8.5-r0" \
    "python3>=3.8.5-r0" \
    "ssmtp>=2.64-r14" \
    "zlib-dev>=1.2.11-r3"

# Python
ENV PYTHONUNBUFFERED=1
RUN pip install --upgrade "pip>==20.2b1" "setuptools>==46.1.3"

## ssmtp
SHELL ["/bin/ash", "-o", "pipefail", "-c"]
RUN cp /etc/ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf.dist \
    && sed 's/^mailhub=mail/mailhub=smtp:1025/g' /etc/ssmtp/ssmtp.conf.dist | sed 's/^#hostname/hostname/g' > /etc/ssmtp/ssmtp.conf \
    && printf "FromLineOverride=%s\n" 'YES' >> /etc/ssmtp/ssmtp.conf

# PHP
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions \
    && sync
RUN install-php-extensions \
    apcu \
    bz2 \
    calendar \
    dba \
    exif \
    gd \
    gettext \
    igbinary \
    imagick \
    intl \
    mcrypt \
    mysqli \
    opcache \
    pcntl \
    pdo_mysql \
    rar \
    redis \
    shmop \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    xdebug \
    xsl \
    zip
RUN printf  "[date]\ndate.timezone = %s\n" 'Asia/Tokyo' > /usr/local/etc/php/conf.d/date.ini \
    && echo "memory_limit=-1" > /usr/local/etc/php/conf.d/memory-limit.ini \
    && printf "[mbstring]\nmbstring.internal_encoding = %s\nmbstring.language = %s\n" 'UTF-8' 'Japanese' > /usr/local/etc/php/conf.d/mbstring.ini \
    && echo "output_buffering = On" > /usr/local/etc/php/conf.d/output-buffering.ini \
    && printf "upload_max_filesize = %s\npost_max_size = %s\n" '500M' '100M' > /usr/local/etc/php/conf.d/upload.ini \
    && printf "phar.readonly = %s\nphar.require_hash = %s\n" 'Off' 'OFF' > /usr/local/etc/php/conf.d/phar-conf.ini \
    && echo 'sendmail_path = "/usr/sbin/ssmtp -t"' > /usr/local/etc/php/conf.d/mail.ini \
    && printf "\nxdebug.remote_enable = %s\nxdebug.remote_autostart = %s" 'On' 'On' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && printf "\nxdebug.remote_connect_back = %s\nxdebug.remote_host = docker.for.mac.localhost" 'Off' >> /usr/local/etc/php/conf.d/xdebug.ini

# composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN chmod uga+x /usr/local/bin/composer

