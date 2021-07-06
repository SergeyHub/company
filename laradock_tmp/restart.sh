docker-compose down \
&& docker-compose up -d nginx mysql php-fpm php-worker redis memcached phpmyadmin laravel-echo-server \
&& docker-compose exec workspace sh -c "php artisan config:cache" \
&& sleep 20 \
&& docker-compose exec workspace sh -c "php artisan migrate" \
