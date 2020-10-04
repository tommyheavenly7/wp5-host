FROM php:7.4-cli-alpine

RUN apk --no-cache add \
    "autoconf>=2.69-r2" \
    "automake>=1.16.1-r0" \
    "build-base>=0.5-r1" \
    "curl>=7.69.1-r1" \
    "ffmpeg>=4.3.1-r0" \
    "g++>=9.2.0-r4" \
    "gcc>=9.2.0-r4" \
    "ghostscript>=9.50-r0" \
    "git>=2.24.1-r0" \
    "gnutls>=3.6.15-r0" \
    "groff>=1.22.4-r0" \
    "icu-dev>=64.2-r1" \
    "imagemagick-dev>=7.0.10.18-r0" \
    "imagemagick>=7.0.10.18-r0" \
    "lcms2-dev>=2.9-r1" \
    "less>=551-r0" \
    "libgit2-dev>=0.28.5-r0" \
    "libjpeg-turbo>=2.0.4-r2" \
    "libjpeg>=8-r6" \
    "libpng-dev>=1.6.37-r1" \
    "libssh>=0.9.4-r1" \
    "libtool>=2.4.6-r7" \
    "libwebp-dev>=1.0.3-r0" \
    "libx11>=1.6.12-r0" \
    "libxml2>=2.9.10-r5" \
    "make>=4.2.1-r2" \
    "mysql-client>=10.4.12-r0" \
    "nasm>=2.14.02-r0" \
    "py-pip>=18.1-r0" \
    "python3-dev>=3.8.5-r0" \
    "python3>=3.8.5-r0" \
    "ssmtp>=2.64-r14" \
    "zlib-dev>=1.2.11-r3"

# Python
RUN pip install --upgrade "pip>==20.2b1" "setuptools>==46.1.3"

## ssmtp
SHELL ["/bin/ash", "-o", "pipefail", "-c"]
RUN cp /etc/ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf.dist \
    && sed 's/^mailhub=mail/mailhub=smtp:1025/g' /etc/ssmtp/ssmtp.conf.dist | sed 's/^#hostname/hostname/g' > /etc/ssmtp/ssmtp.conf \
    && printf "FromLineOverride=%s\n" 'YES' >> /etc/ssmtp/ssmtp.conf

# PHP
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
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

WORKDIR /tmp
RUN wget https://github.com/esminis/php_pecl_rar/archive/v4.0.6.tar.gz \
    && mkdir -p /tmp/rar \
    && tar -xf v4.0.6.tar.gz -C /tmp/rar --strip-components=1 \
    && rm v4.0.6.tar.gz \
    && docker-php-ext-configure /tmp/rar --enable-rar \
    && docker-php-ext-install /tmp/rar \
    && rm -r /tmp/rar

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
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet \
    && cp composer.phar /usr/local/bin/composer

