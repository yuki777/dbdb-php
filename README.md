# dbdb-php

dbdb-php is a plugin for composer that allows you to manage databases with [dbdb](https://github.com/yuki777/dbdb).

## Install

```bash
# Allow plugin
composer config allow-plugins.yuki777/dbdb-php true

# Install
# Don't forget "-dev".  Databases started by "dbdb-php" are not suitable for production environments.
composer require --dev yuki777/dbdb-php
```

## Usage

```bash
# Create database
composer dbdb:mysql-create my-awesome-db 5.7.31 3306

# Start database
composer dbdb:mysql-start my-awesome-db

# Stop database
composer dbdb:mysql-stop my-awesome-db

# Restart database
composer dbdb:mysql-restart my-awesome-db

# Delete database
composer dbdb:mysql-delete my-awesome-db

# Try create, then start database
composer dbdb:mysql-create-start my-awesome-db 5.7.31 3306

# Show port
composer dbdb:mysql-port my-awesome-db

# Show databases
composer dbdb:list
```
