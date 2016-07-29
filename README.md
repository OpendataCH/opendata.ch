# opendata.ch

WordPress for the Opendata.ch website.

## Requirements

- PHP 7.0
- MySQL 5.7
- [Composer](https://getcomposer.org/download/)

## Installation

1. `git clone https://github.com/OpendataCH/opendata.ch.git`
2. `cd opendata.ch/`
3. `composer install` (installs WordPress into the directory `wordpress/`)
4. `cp wp-config.php.dev wp-config.php`
5. Copy database from server
6. `docker-compose up`
