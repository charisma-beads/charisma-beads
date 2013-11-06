#!/bin/sh

cd ../

php composer.phar self-update
php composer.phar update

git pull
