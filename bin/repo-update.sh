#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

git fetch --tags

CB_VERSION=$(git describe --tags $(git rev-list --tags --max-count=1))
echo ${CB_VERSION^^}

git checkout ${CB__VERSION^^}
git pull
