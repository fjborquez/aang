FROM serversideup/php:8.3-fpm-alpine

ENV APP_ENV=local
ENV APP_DEBUG=true
ENV PHP_MEMORY_LIMIT=512M

RUN chown -R www-data:www-data /var/www/
COPY . /var/www/html
RUN chmod 777 -R /var/www/html/storage/

RUN composer install --optimize-autoloader

RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan cache:clear
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate
RUN php artisan db:seed

RUN a2enmod rewrite
