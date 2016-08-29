#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR
cd ../

git pull
git fetch --tags

CB_VERSION="tags/"$(git describe --tags $(git rev-list --tags --max-count=1))
echo "lastest version to install:" ${CB_VERSION}

git checkout "${CB_VERSION}"

echo "current version:"
git describe --tags
