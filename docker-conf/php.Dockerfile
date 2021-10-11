FROM php:8.0-fpm

ENV TZ=Europe/Moscow
RUN \
	apt-get update \
	&& apt-get install -y \
		build-essential \
		cron \
		git \
		locales \
		openssl \
		pkg-config \
		unzip \
        zlib1g-dev \
        libmemcached-dev \
        tzdata \
        libzip-dev \
        zip \
        libpng-dev

# Install PHP extensions which depend on external libraries
RUN \
    apt-get install -y --no-install-recommends libssl-dev libcurl4-openssl-dev \
    && docker-php-ext-configure curl --with-curl \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) curl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && cp /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN pecl install imagick && docker-php-ext-enable imagick
RUN pecl install memcache && docker-php-ext-enable memcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN echo 'max_execution_time = 0' >> /usr/local/etc/php/conf.d/docker-php-maxexectime.ini;
RUN echo date.timezone=$TZ >> /usr/local/etc/php/conf.d/docker-php-timezone.ini;


CMD bash -c "cd /app && rm -rf source/adminPanel/web/assets/* && composer install && php-fpm"