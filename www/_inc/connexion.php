<?php if(!defined('_DTLR')) exit('Unauthorized');


function connect($oDb, $login, $password, $announcement=false) {
	// by default
	$answer = 'Erreur de connexion';
	$state = 'fail';

	// after he sent the form
	if(!empty($login) && !empty($password)) {
		// if successfully connected to the database
		if($oDb->connect($login, $password)) {
			$answer = 'Vous vous êtes bien connecté en tant que ' . $login;
			$state = 'success';

			$_SESSION['login'] = $login;
			$_SESSION['password'] = $password;
		}

		// print connection state
		if($announcement) echo "<div id='connection-state' class='$state'>$answer</div>";
	}

	return $state == 'success';
}