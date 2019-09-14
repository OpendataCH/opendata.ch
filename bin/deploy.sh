#!/bin/bash

ssh -o ForwardAgent=yes www-data@opendata02.nine.ch "cd /home/www-data/opendata.ch && git pull --rebase --stat && /home/www-data/bin/composer update --no-dev --no-interaction --no-progress --optimize-autoloader"
