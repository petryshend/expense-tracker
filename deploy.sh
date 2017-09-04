#!/usr/bin/env bash

git pull --rebase
composer install
php doctrine.php migrations:migrate -n
