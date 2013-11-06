#!/bin/sh

curl -sS https://getcomposer.org/installer | php

php composer install

cp assests/.htaccess public/.htaccess
