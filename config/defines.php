<?php

ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('error_reporting', E_ALL);

define('ALIAS', 'ancluiche');
define('APP_DIR', realpath(''));
define('APP_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . ALIAS);
define('DS', DIRECTORY_SEPARATOR);
define('DB_DSN', 'mysql:dbname=gaa;host=127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DEFAULT_LANG', 'en');

