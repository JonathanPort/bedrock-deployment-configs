<?php

if (getenv('CLEARDB_DATABASE_URL')) {

	$dbUrl = getenv('CLEARDB_DATABASE_URL');

} elseif (getenv('JAWSDB_URL')) {

	$dbUrl = getenv('JAWSDB_URL');

} else {
	$dbUrl = null;
}

if ($dbUrl) {

	$_dbsettings = parse_url($dbUrl);

	define('DB_NAME',     trim($_dbsettings['path'], '/'));
	define('DB_USER',     $_dbsettings['user']);
	define('DB_PASSWORD', $_dbsettings['pass']);
	define('DB_HOST',     $_dbsettings['host']);
}