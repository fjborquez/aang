FROM laratips/laravel10:latest

ENV APP_ENV=local
ENV APP_DEBUG=false
ENV PHP_MEMORY_LIMIT=128M

COPY . /var/www/html

RUN composer install --optimize-autoloader

RUN php artisan migrate
