# dbdb-php

dbdb-php is a plugin for composer that allows you to manage databases with [dbdb](https://github.com/yuki777/dbdb).

## Install locally

```bash
# Allow plugin
composer config allow-plugins.yuki777/dbdb-php true

# Install
# Don't forget "--dev".  Databases started by "dbdb-php" are not suitable for production.
composer require --dev yuki777/dbdb-php
```
## Install globally

```bash
# Allow plugin
composer global config allow-plugins.yuki777/dbdb-php true

# Install
# Don't forget "--dev".  Databases started by "dbdb-php" are not suitable for production.
composer global require --dev yuki777/dbdb-php
```

## Usage

```bash
# Create database with version 5.7.31 and port 3306
composer dbdb:mysql create --db-name=my-awesome-db5 --db-version=5.7.31 --db-port=3306

# Start database
composer dbdb:mysql start --db-name=my-awesome-db5

# Stop database
composer dbdb:mysql stop --db-name=my-awesome-db5

# Restart database
composer dbdb:mysql restart --db-name=my-awesome-db5

# Delete database
composer dbdb:mysql delete --db-name=my-awesome-db5

# Create and start database
composer dbdb:mysql create-start --db-name=my-awesome-db5 --db-version=5.7.31 --db-port=3306

# Create database with version 8.0.30 and random port
composer dbdb:mysql create --db-name=my-awesome-db8 --db-version=8.0.30 --db-port=random

# Show port
composer dbdb:mysql-port my-awesome-db8

# Show databases
composer dbdb:list
```

## Supported databases and versions
- MySQL
  - 5.7.31
  - 8.0.30
- Redis
  - 6.0.16
  - 6.2.6
- Postgresql
  - 12.4
  - 12.6
  - 13.2
- Mongodb
  - 4.4.10
  - 5.0.3

## Example
- [Here is an example](https://github.com/yuki777/dbdb-php-laravel/blob/main/.github/workflows/test.yaml) of Laravel using a MySQL database without a MySQL container in CI (GitHub Actions).
