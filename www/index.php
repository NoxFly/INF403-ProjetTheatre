<?php
/**
 * package: PROJET THEATRE
 * authors: Dorian Thivolle
 *          Lilian Russo
 */

// security constant
define('_DTLR', true);


// defines
define('BASE_PATH', __DIR__);
define('VIEW_PATH', realpath(BASE_PATH.'/../views'));

$local = $_SERVER['SERVER_NAME'] == 'localhost';


// config recovery
// determine which config we must use
$confPath = BASE_PATH.'/_conf/'.($local?'local.':'').'config.ini';
 
if(!file_exists($confPath)) {
    die("<h1>Impossible to access to the config file</h1>");
}

$config = parse_ini_file($confPath, true);

$config['env'] = [
    'base_dir' => BASE_PATH,
    'view_dir' => VIEW_PATH
];
//


// error dev - localhost only
if($local) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// if remote website, then activate the database
else {
	require_once(BASE_PATH.'/_conf/oci_database.php');
	$oDb = new Database($config['database']);
}

// Website class
require_once(BASE_PATH.'/_conf/site.php');
$oSite = new Site($config);

// add the website template
require_once(BASE_PATH.'/theme/template.php');