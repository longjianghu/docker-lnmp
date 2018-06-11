#!/bin/sh

set -e

if [ "$1" = "fpm" ]; then
    php-fpm -F
elif [ "$1" = "php" ]; then
	php $2
else
	exec "$@"
fi