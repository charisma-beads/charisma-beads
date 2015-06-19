#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

git stash
git stash drop
git pull

php5 -d memory_limit=512M ./data/upgrade/upgrade-all.php
