#!/bin/bash

cd $(dirname $0)

# load settings 
source ./settings.sh



ssh www-data@opendata02.nine.ch "mysqldump -u nmd_opendata_ch $databasePassword --no-tablespaces nmd_opendata_ch | gzip -c1" | gunzip -c | sed -e 's/USING BTREE//' | docker-compose run --no-TTY --rm mysql /usr/bin/mysql -h mysql -u root opendata

docker-compose run --no-TTY --rm mysql /usr/bin/mysql -h mysql -u root opendata --execute=" \

    UPDATE wp_site SET domain = 'localhost:8000' where domain = 'opendata.ch'; \

    UPDATE wp_blogs SET domain = 'localhost:8001' where domain = 'fr.opendata.ch'; \
    UPDATE wp_3_options SET option_value = 'http://localhost:8001/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_3_options SET option_value = 'http://localhost:8001/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8002' where domain = 'make.opendata.ch'; \
    UPDATE wp_5_options SET option_value = 'http://localhost:8002/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_5_options SET option_value = 'http://localhost:8002/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8003' where domain = 'glam.opendata.ch'; \
    UPDATE wp_6_options SET option_value = 'http://localhost:8003/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_6_options SET option_value = 'http://localhost:8003/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8004' where domain = 'energy.opendata.ch'; \
    UPDATE wp_11_options SET option_value = 'http://localhost:8004/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_11_options SET option_value = 'http://localhost:8004/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8005' where domain = 'finance.opendata.ch'; \
    UPDATE wp_8_options SET option_value = 'http://localhost:8005/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_8_options SET option_value = 'http://localhost:8005/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8006' where domain = 'food.opendata.ch'; \
    UPDATE wp_12_options SET option_value = 'http://localhost:8006/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_12_options SET option_value = 'http://localhost:8006/' WHERE option_name = 'home'; \

    UPDATE wp_blogs SET domain = 'localhost:8000' where domain = 'opendata.ch'; \
    UPDATE wp_15_options SET option_value = 'http://localhost:8000/wordpress' WHERE option_name = 'siteurl'; \
    UPDATE wp_15_options SET option_value = 'http://localhost:8000/' WHERE option_name = 'home'; \
"

echo "Syncing files"
rsync -avr --delete-after www-data@opendata02.nine.ch:/home/www-data/opendata.ch/wordpress/ ../wordpress/
rsync -avr --delete-after www-data@opendata02.nine.ch:/home/www-data/opendata.ch/wp-content/plugins/ ../wp-content/plugins/
rsync -avr --delete-after www-data@opendata02.nine.ch:/home/www-data/opendata.ch/wp-content/uploads/ ../wp-content/uploads/
rsync -avr --delete-after www-data@opendata02.nine.ch:/home/www-data/opendata.ch/wp-content/languages/ ../wp-content/languages/
