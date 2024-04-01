FROM laratips/laravel10:latest

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PHP_MEMORY_LIMIT=128M

COPY . /var/www/html

RUN composer install --optimize-autoloader

RUN php artisan migrate && \
    chmod 777 -R /var/www/html/storage/ && \
    chown -R www-data:www-data /var/www/ && \
    a2enmod rewrite
