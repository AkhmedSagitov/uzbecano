#!/usr/bin/env bash

workspace=$1
stage=$2

cd $workspace/Build
composer i --no-progress --optimize-autoloader --no-dev
if vendor/bin/dep deploy stage=$stage -v; then
  exit 0
fi

vendor/bin/dep deploy:unlock stage=$stage

exit 1
