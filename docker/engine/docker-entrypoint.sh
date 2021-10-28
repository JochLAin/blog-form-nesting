#!/bin/bash

# If project is installed
#if [ -d 'vendor' ]; then
#    php bin/console --env=prod doctrine:schema:update --force
#    composer run-script post-update-cmd
#fi

mkdir -p /home/docker/var/sessions
chmod 777 -R \
    /home/docker/var/cache \
    /home/docker/var/log \
    /home/docker/var/sessions

exec "$@"
