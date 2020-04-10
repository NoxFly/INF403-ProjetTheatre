<?php if(!defined('_DTLR')) exit('Unauthorized');

$arg = str_replace('spectacle-dossier/', '', $this->getPage());

// want to show a version of
if(preg_match("/^v\d(\/\d+)?$/", $arg) && in_array(($v = intval(preg_replace('/v(\d)(\/\d+)?/', '$1', $arg))), [1, 2, 3])) {
	echo "<h2>Version $v</h2>
		<h1 style='margin-top: 0;'>Spectacle dossier</h1>";

	$noBackrest = ($v!=3)? preg_replace('/v\d\/(\d+)/', '$1', $arg) : null;
	if($noBackrest == "v$v") echo "<p style='text-align: center; color: #444; margin-bottom: 100px;'>Argument dans l'url non accepté</p>";
	else include BASE_PATH . "/_inc/spec-dos-v$v.php";
}



// else want to see backrest's details - why post and not get ? because of the website structure, get isn't working well
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
	echo "<p style='text-align: center; color: #444; margin-top: 100px;'>Argument dans l'url non accepté</p>";
}