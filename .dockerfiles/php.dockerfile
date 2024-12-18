FROM php:8.0-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel && \
    adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf && \
    echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install \
    pcntl

RUN docker-php-ext-install pdo_mysql

RUN apk add --no-cache zip libzip-dev && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip

RUN apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp \
    libwebp-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

RUN apk add  --no-cache ffmpeg

USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
