FROM dunglas/frankenphp:php8.2

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y unzip zip && \
    install-php-extensions intl zip mysqli pdo_mysql

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
