#!/usr/bin/env bash

# although this script is created to automate repeated processes,
# but it's recommended to execute each step in this file manually first

dirnow=$(dirname $(realpath $0))
dirroot=$(realpath "$dirnow/..")
printf "\n --- ROOT directory: $dirroot \n"

cd $dirroot

#-- delete build directory
rm -rf $dirroot/build

#-- fresh composer install & update
rm -rf vendor
composer install --no-interaction
composer update -W --no-interaction --lock
composer update -W --no-interaction

#-- install npm-check-updates
npm install -g npm-check-updates
ncu -u

#-- fresh install node modules
npm install -g
npm install -g grunt-cli

#-- do grunt build
grunt precommit:verify --force
grunt precommit
