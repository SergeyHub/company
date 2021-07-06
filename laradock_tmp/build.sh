docker-compose down \
&& rm -Rf ~/.laradock/data/mysql \
&& docker-compose build --no-cache mysql memcached redis \
&& docker-compose up -d nginx mysql php-fpm php-worker redis memcached \
&& docker-compose exec workspace sh -c "composer install" \
&& docker-compose exec workspace sh -c "php artisan config:cache" \
&& sleep 20 \
&& docker-compose exec workspace sh -c "php artisan migrate" \
&& docker-compose exec workspace sh -c "php artisan db:seed" \
&& docker-compose exec workspace sh -c "php artisan storage:link" \
&& docker-compose exec workspace sh -c "php artisan passport:install"
