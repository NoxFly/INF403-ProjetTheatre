<?php if(!defined('_DTLR')) exit('Unauthorized');

/**
 * Essaie de se connecter à la base de donnée Oracle
 * @param  object $oDb			classe qui gère la base de donnée
 * @param  string $login		nom de connection
 * @param  string $password		mot de passe
 * @param  bool   $announcement popup qui indique si connection réussie ou pas
 * @return bool   connexion réussie ou non
 */
function connect($oDb, $login, $password, $announcement=false) {
	// par défaut
	$answer = 'Erreur de connexion';
	$state = 'fail';

	// après qu'il ait envoyé le formulaire
	if(!empty($login) && !empty($password)) {

		// connection réussie
		if($oDb->connect($login, $password)) {
			$answer = 'Vous vous êtes bien connecté en tant que ' . $login;
			$state = 'success';

			$_SESSION['login'] = $login;
			$_SESSION['password'] = $password;
		}

		// connection fail
		if($announcement) echo "<div id='connexion-state' class='$state'>$answer</div>";
	}

	return $state == 'success';
}