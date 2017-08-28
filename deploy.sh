#!/usr/bin/env bash

git pull --rebase
composer install
vendor/bin/phinx migrate
