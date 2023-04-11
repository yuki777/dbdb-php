# dbdb-php

dbdb-php is a plugin for composer that allows you to manage databases with [dbdb](https://github.com/yuki777/dbdb).

## Install

```bash
# Allow plugin
composer config allow-plugins.yuki777/dbdb-php true

# Install
# Don't forget "--dev".  Databases started by "dbdb-php" are not suitable for production.
composer require --dev yuki777/dbdb-php
```

## Usage

```bash
# Create database with version 5.7.31 and port 3306
composer dbdb:mysql-create my-awesome-db 5.7.31 3306

# Start database
composer dbdb:mysql-start my-awesome-db

# Stop database
composer dbdb:mysql-stop my-awesome-db

# Restart database
composer dbdb:mysql-restart my-awesome-db

# Delete database
composer dbdb:mysql-delete my-awesome-db

# Create database, then start database
composer dbdb:mysql-create-start my-awesome-db 5.7.31 3306

# Create database with version 8.0.30 and random port
composer dbdb:mysql-create my-awesome-db 8.0.30 random

# Show port
composer dbdb:mysql-port my-awesome-db

# Show databases
composer dbdb:list
```

## Supported MySQL versions

- 5.7.31
- 8.0.30
