#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

/usr/local/php7/bin/php ./composer.phar self-update
/usr/local/php7/bin/php ./composer.phar --no-dev install
