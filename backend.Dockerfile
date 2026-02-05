FROM php:8.2-apache

# 1. Instalar dependencias del sistema y locales UTF-8
RUN apt-get update && apt-get install -y \
        locales \
        libonig-dev \
        libzip-dev \
        zip \
        unzip \
    && sed -i 's/# es_ES.UTF-8 UTF-8/es_ES.UTF-8 UTF-8/' /etc/locale.gen \
    && sed -i 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen \
    && locale-gen \
    && update-locale LANG=en_US.UTF-8

ENV LANG=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    LC_ALL=en_US.UTF-8

# 2. Configurar Apache para UTF-8
RUN echo "AddDefaultCharset UTF-8" >> /etc/apache2/conf-available/charset.conf \
    && a2enconf charset

# 3. Configurar PHP para UTF-8
RUN { \
        echo "default_charset = \"UTF-8\""; \
        echo "mbstring.language = Neutral"; \
        echo "mbstring.internal_encoding = UTF-8"; \
        echo "mbstring.http_input = UTF-8"; \
        echo "mbstring.http_output = UTF-8"; \
    } > /usr/local/etc/php/conf.d/utf8.ini

# 4. Instalar extensiones PHP necesarias
RUN docker-php-ext-install mbstring pdo pdo_mysql mysqli

# 5. Copiar tus archivos PHP
COPY *.php /var/www/html/
COPY img /var/www/html/img

# 6. Exponer puerto
EXPOSE 80
