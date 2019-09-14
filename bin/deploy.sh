#!/bin/bash

ssh -o ForwardAgent=yes www-data@opendata02.nine.ch <<END
  cd /home/www-data/opendata.ch &&
  git pull --rebase --stat &&
  composer update --no-dev --no-interaction --no-progress --optimize-autoloader
END
