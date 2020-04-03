<?php
/**
 * package: PROJET THEATRE
 * authors: Dorian Thivolle
 *          Lilian Russo
 */

// error dev - localhost only
if($_SERVER['SERVER_NAME'] == 'localhost') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
// security constant
define('_NOX', true);


// defines
define('BASE_PATH', __DIR__);
define('VIEW_PATH', realpath(BASE_PATH.'/../views'));


// determine which config we must use
$loc = $_SERVER['SERVER_NAME'] == 'localhost'? 'local.' : '';





// récupération fichier ini
$confPath = BASE_PATH.'/_conf/'.$loc.'config.ini';
 
if(!file_exists($confPath)) {
    die("<h1>Impossible d'accéder au fichier config</h1>");
}

$config = parse_ini_file($confPath, true);
//


$config['env'] = [
    'base_dir' => BASE_PATH,
    'view_dir' => VIEW_PATH
];

// création de la classe structurant le site
require_once(BASE_PATH.'/_conf/site.php');
$oSite = new Site($config);

// création relation base de données
require_once(BASE_PATH.'/_conf/'.$config['database']['type'].'_database.php');
$oDb = new Database($config['database']);

require_once(BASE_PATH.'/theme/template.php');