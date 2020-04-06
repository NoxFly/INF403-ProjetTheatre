<?php if(!defined('_DTLR')) exit('Unauthorized');

/** PROBLEME DE VARIABLE $oSite->getBaseUrl() ICI */
// il faudrait le remplacer dans action=""
?>

<h1>Connexion</h1>

<div id='connection-form'>
	<form method='post' action="<?php echo '/public/projet_theatre/www/index.php'; ?>">
		<input type='text' name='login' required>
		<input type='password' name='password' required>

		<button id='connect'>Connexion</button>
	</form>
</div>