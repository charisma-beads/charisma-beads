#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

php-cli composer.phar self-update
php-cli composer.phar --no-dev update
