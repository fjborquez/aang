FROM laratips/laravel10:latest

ENV APP_ENV=local
ENV APP_DEBUG=true
ENV PHP_MEMORY_LIMIT=512M

COPY . /var/www/html

RUN apt-get update -qq   && apt-get install -y -qq python3.8
RUN rm /usr/bin/python && rm /usr/bin/python3 && ln -s /usr/bin/python3.8 /usr/bin/python &&  ln -s /usr/bin/python3.8 /usr/bin/python3 \
    && rm /usr/local/bin/python && rm /usr/local/bin/python3 && ln -s /usr/bin/python3.8 /usr/local/bin/python &&  ln -s /usr/bin/python3.8 /usr/local/bin/python3 \
    && apt-get install -y python3-pip python-dev python3.8-dev && python3 -m pip install pip --upgrade


RUN composer install --optimize-autoloader

RUN curl -sSL https://sdk.cloud.google.com > /tmp/gcl && bash /tmp/gcl --install-dir=~/gcloud --disable-prompts
RUN gcloud kms decrypt --ciphertext-file=/workspace/envs/.env.prod.enc --plaintext-file=/workspace/.env --location=global --keyring=aang-envs --key=key-envs --verbosity=debug

RUN php artisan config:cache
RUN php artisan cache:clear
RUN php artisan route:cache
RUN php artisan view:cache
RUN php artisan migrate
RUN php artisan db:seed
RUN chmod 777 -R /var/www/html/storage/
RUN chown -R www-data:www-data /var/www/
RUN a2enmod rewrite
