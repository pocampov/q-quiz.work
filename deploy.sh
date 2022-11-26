#!/bin/sh
php artisan modelCache:clear
php artisan clear:compiled
php artisan route:cache
php artisan event:cache
php artisan view:cache
php artisan config:cache
php artisan queue:restart
php artisan key:generate
