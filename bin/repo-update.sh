#!/bin/sh

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

git stash
git stash drop
git pull

php5 ./data/upgrade/upgrade-all.php
