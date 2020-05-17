<?php if(!defined('_DTLR')) exit('Unauthorized');

$arg = str_replace('spectacle-dossier/', '', $this->getPage());

// si on veut voir une version 1/2/3
if(preg_match("/^v\d(\/\d+)?$/", $arg) && in_array(($v = intval(preg_replace('/v(\d)(\/\d+)?/', '$1', $arg))), [1, 2, 3])) {
	echo "<h2>Version $v</h2>
		<h1 style='margin-top: 0;'>Spectacle dossier</h1>";

	$noBackrest = ($v!=3)? preg_replace('/v\d\/(\d+)/', '$1', $arg) : null;
	
	if($noBackrest == "v$v") echo "<p class='desc'>url non accepté</p>";

	// on inclut la version demandée
	else include BASE_PATH . "/_inc/spec-dos-v$v.php";
}



// sinon on veut voir le détail d'un dossier
else if(preg_match("/^\d+$/", $arg)) {
	echo '<h1>Spectacle dossier</h1>
	<form method="POST" action="">
		<input type="text" name="category" placeholder="Catégorie...">
		<button>OK</button>
	</form>';
	
	$noBackrest = $arg;

	include BASE_PATH . '/_inc/spec-dos-action.php';
}

else {
	echo "<p class='desc'url non accepté</p>";
}