#!/bin/sh

curl -sS https://getcomposer.org/installer | php

COMPOSER_HOME="/home/charisma" php composer.phar --prefer-dist install

#cp assests/.htaccess public/.htaccess
