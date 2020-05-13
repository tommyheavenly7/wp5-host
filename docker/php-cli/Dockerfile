FROM php:7.4-cli-alpine

RUN apk --no-cache add \
    "autoconf>=2.69-r2" \
    "automake>=1.16.1-r0" \
    "build-base>=0.5-r1" \
    "curl>=7.67.0-r0" \
    "g++>=9.2.0-r4" \
    "gcc>=9.2.0-r4" \
    "ghostscript>=9.50-r0" \
    "git>=2.24.1-r0" \
    "groff>=1.22.4-r0" \
    "icu-dev>=64.2-r1" \
    "imagemagick-dev>=7.0.9.7-r0" \
    "imagemagick>=7.0.9.7-r0" \
    "lcms2-dev>=2.9-r1" \
    "less>=551-r0" \
    "libgit2-dev>=0.28.5-r0" \
    "libjpeg>=8-r6" \
    "libpng-dev>=1.6.37-r1" \
    "libtool>=2.4.6-r7" \
    "make>=4.2.1-r2" \
    "mysql-client>=10.4.12-r0" \
    "nasm>=2.14.02-r0" \
    "python3-dev>=3.8.2-r0" \
    "python3>=3.8.2-r0" \
    "ssmtp>=2.64-r14" \
    "zlib-dev>=1.2.11-r3"

# Python
RUN pip3 install --upgrade "pip>==20.0.2" "setuptools>==46.1.3"

## ssmtp
SHELL ["/bin/ash", "-o", "pipefail", "-c"]
RUN cp /etc/ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf.dist \
    && sed 's/^mailhub=mail/mailhub=smtp:1025/g' /etc/ssmtp/ssmtp.conf.dist | sed 's/^#hostname/hostname/g' > /etc/ssmtp/ssmtp.conf \
    && printf "FromLineOverride=%s\n" 'YES' >> /etc/ssmtp/ssmtp.conf

# PHP
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions \
    && sync
RUN install-php-extensions apcu
RUN install-php-extensions bz2
RUN install-php-extensions calendar
RUN install-php-extensions dba
RUN install-php-extensions exif
RUN install-php-extensions gd
RUN install-php-extensions gettext
RUN install-php-extensions igbinary
RUN install-php-extensions imagick
RUN install-php-extensions intl
RUN install-php-extensions mcrypt
RUN install-php-extensions mysqli
RUN install-php-extensions opcache
RUN install-php-extensions pcntl
RUN install-php-extensions pdo_mysql
RUN install-php-extensions redis
RUN install-php-extensions shmop
RUN install-php-extensions soap
RUN install-php-extensions sockets
RUN install-php-extensions sysvmsg
RUN install-php-extensions sysvsem
RUN install-php-extensions sysvshm
RUN install-php-extensions xdebug
RUN install-php-extensions xsl
RUN install-php-extensions zip

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
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet && \
    cp composer.phar /usr/local/bin/composer

