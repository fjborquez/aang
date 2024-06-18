FROM laratips/laravel10:latest

ENV APP_ENV=local
ENV APP_DEBUG=true
ENV PHP_MEMORY_LIMIT=512M

COPY . /var/www/html

RUN composer install --optimize-autoloader

RUN php artisan key:generate
RUN php artisan migrate
RUN php artisan db:seed
RUN chmod 777 -R /var/www/html/storage/
RUN chown -R www-data:www-data /var/www/
RUN a2enmod rewrite
