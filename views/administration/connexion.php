<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Connexion</h1>

<div id='connection-form'>
	<form method='post' action="<?php echo $this->getBaseUrl().'/index.php'; ?>">
		<input type='text' name='login' required>
		<input type='password' name='password' required>

		<button id='connect'>Connexion</button>
	</form>
</div>