#!/bin/sh

curl -sS https://getcomposer.org/installer | php

php composer.phar install

cp assests/.htaccess public/.htaccess
