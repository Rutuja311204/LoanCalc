FROM dunglas/frankenphp:1-php8.2

RUN install-php-extensions intl mysqli pdo_mysql

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
