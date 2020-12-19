#!/usr/bin/env bash

bin/console survos:user:create tt@survos.com tt --roles ROLE_ADMIN
bin/console survos:user:create  tacman@gmail.com nosmoke
bin/console survos:user:create  dennis@gmail.com rappnews

bin/console survos:user:create  gborio@gmail.com geneb555 --roles ROLE_ADMIN --force

#bin/console survos:user:create  admin@survos.com admin --roles ROLE_ADMIN
#
#bin/console survos:user:create  patrick@survos.com admin
#
#
#
#bin/console survos:user:create  tacman+2@gmail.com tt
bin/console survos:user:create  linda@survos.com linda --roles ROLE_META --force
