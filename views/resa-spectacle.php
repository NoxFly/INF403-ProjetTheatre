<?php if(!defined('_DTLR')) exit('Unauthorized');

$arg = str_replace('resa-spectacle/', '', $this->getPage());

// argument invalide
if(!in_array($arg, ['1', '2'])) {

	echo "<p class='desc'>version non existante</p>";

}

// argument valide - version existante
else {
	// regarde la version demandée
	$v = $arg . ' curseur' . (($arg=='1')? '' : 's');

	echo "<h2>Version $v</h2>
	<h1 style='margin-top: 0;'>Réservations d'un spectacle</h1>";

	// on inclut le fichier de la version demandée
	include BASE_PATH . "/_inc/resa-spec-$arg-cur.php";
}
