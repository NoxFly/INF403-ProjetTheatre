<?php
/**
 * package: PROJET THEATRE
 * authors: Dorian Thivolle
 *          Lilian Russo
 */

// security constant
define('_DTLR', true);


session_start();



// defines
define('BASE_PATH', __DIR__);
define('VIEW_PATH', realpath(BASE_PATH.'/../views'));




$local = $_SERVER['SERVER_NAME'] == 'localhost';

// error dev - localhost only
if($local) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}




// config recovery
// determine which config we must use
$confPath = BASE_PATH.'/_conf/config.ini';
 
if(!file_exists($confPath)) {
    die("<h1>Impossible to access to the config file</h1>");
}

$config = parse_ini_file($confPath, true);

$config['env'] = [
    'base_dir' => BASE_PATH,
    'view_dir' => VIEW_PATH
];
//




// Database class
require_once BASE_PATH.'/_conf/database.php';

// Website class
require_once BASE_PATH.'/_conf/site.php';
$oSite = new Site($config);



//
// to connect to the database
require_once BASE_PATH.'/_inc/connexion.php';

// if it's by the form
if(isset($_POST['login']) && isset($_POST['password'])) {
	if(connect($oSite->db, $_POST['login'], $_POST['password'], true)) {
		$oSite->setConnection(true);
	}
}

// else, if it's by session
else if(isset($_SESSION['login']) && isset($_SESSION['password']) &&
		$_SESSION['login'] != null && $_SESSION['password'] != null) {
	if(connect($oSite->db, $_SESSION['login'], $_SESSION['password'])) {
		$oSite->setConnection(true);
	}
}
//

// if user attemps to show a page that requires connection while he is not
if(!$oSite->isConnected() && !in_array($oSite->getPage(), ['', 'accueil', 'administration/connexion'])) {
	header('location: '.$oSite->getBaseUrl());
}

$oSite->createContent();


// add the website template
require_once BASE_PATH.'/theme/template.php';