#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

rm ./data/cache/*.php

php7.1 composer.phar self-update
php7.1 composer.phar --no-dev install
