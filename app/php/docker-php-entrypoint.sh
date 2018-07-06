#!/bin/sh
set -e

su www-data -c "composer config -g repo.packagist composer https://packagist.phpcomposer.com"

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

exec "$@"
