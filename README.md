# opendata.ch

WordPress for the Opendata.ch website.

## Requirements

- PHP 7.4
- MySQL 8.0
- [Composer](https://getcomposer.org/download/)

## Installation

1. `git clone https://github.com/OpendataCH/opendata.ch.git`
2. `cd opendata.ch/`
3. `wp core download --path=wordpress --version=5.6.14` (installs WordPress into the directory `wordpress/`)
4. `cp wp-config.php.dev wp-config.php`
5. Copy database from server
6. Copy plugins from server
7. `docker-compose up`
