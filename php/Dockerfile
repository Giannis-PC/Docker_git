FROM php:8.0.20-fpm

RUN apt-get update && apt-get install -y zlib1g-dev \
    libpng-dev \
    libxml2-dev \
    libssl-dev \
    vim \
    wget \
    curl \
    gnupg \
    libonig-dev \
    libzip-dev \
    libxrender1 \
    libfontconfig1 \
    libx11-dev \
    libjpeg62 \
    libxtst6 \
    supervisor

RUN docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo_mysql \
    mbstring \
    bcmath
#    zip \
#    pcntl \
#    gd \
#    iconv \
#    xml \
#    ctype \
#    json \
#    tokenizer \
#    calendar \
#    soap \
#    intl