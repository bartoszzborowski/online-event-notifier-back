FROM shippingdocker/php-composer:latest
COPY . /app
WORKDIR /app
RUN composer install
CMD php artisan serve --host 0.0.0.0 --port 8020
EXPOSE 8020
