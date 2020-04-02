<?php
/**
 * package: PROJET THEATRE
 * authors: Dorian Thivolle
 *          Lilian Russo
 */

// error dev
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// defines
define('BASEPATH', __DIR__);




// récupération fichier ini
$confPath = BASEPATH.'/_conf/model.config.ini';
 
if(!file_exists($confPath)) {
    die("<h1>Impossible d'accéder au fichier config</h1>");
}

$config = parse_ini_file($confPath, true);
//

// création relation base de données
require_once(BASEPATH.'/_conf/database.php');
$oDb = new Database($config['database']['host'], $config['database']['service_name'], $config['database']['port'], $config['database']['username'], $config['database']['password']);

require_once(BASEPATH.'/theme/template.php');