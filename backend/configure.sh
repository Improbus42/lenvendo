#!/bin/bash
sudo docker-compose exec php-cli bash
composer install
php artisan migrate
chmod 777 * -R storage
