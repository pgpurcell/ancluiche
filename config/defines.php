<?php

ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('error_reporting', E_ALL);

define('ALIAS', 'ancluiche');
define('APP_DIR', realpath(''));
define('APP_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . ALIAS);
define('DS', DIRECTORY_SEPARATOR);

// PP 28/09/2012 - will not be needed if ez_sql works
/*
define('DB_DSN', 'mysql:dbname=ancluiche;host=127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
*/

define('DEFAULT_LANG', 'en');

/* ez_sql defines */
define("EZSQL_DB_USER", "root");			// <-- mysql db user
define("EZSQL_DB_PASSWORD", "");		// <-- mysql db password
define("EZSQL_DB_NAME", "ancluiche");		// <-- mysql db pname
define("EZSQL_DB_HOST", "localhost");	// <-- mysql server host
define("EZSQL_VERSION","1.01");
define("OBJECT","OBJECT",true);
define("ARRAY_A","ARRAY_A",true);
define("ARRAY_N","ARRAY_N",true);
/* ez_sql defines */
