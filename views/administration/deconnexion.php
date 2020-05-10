<?php

if(!defined('_DTLR')) exit('Unauthorized');

if(isset($_SESSION['login']) && isset($_SESSION['password'])) {
	echo 'ok';
	$_SESSION['login'] = null;
	$_SESSION['password'] = null;
	session_unset();
}

// in all the cases, return to the home
header('location: '.$this->getBaseUrl().'/index.php');