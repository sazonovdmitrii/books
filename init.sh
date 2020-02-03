#!/bin/bash
docker-compose exec book_php composer install
docker-compose exec book_php bin/console doctrine:migrations:migrate
docker-compose exec book_php bin/console doctrine:fixtures:load
docker-compose exec book_php bin/phpunit