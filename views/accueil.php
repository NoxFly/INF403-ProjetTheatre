<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Théâtre LeeNox</h1>

<?php

if($this->isConnected()) {
	$tables = $this->db()->listTables();
	
	echo '<pre>';
		print_r($tables);
	echo '</pre>';
} else {
	echo "<a class='btn home-ctn' href='administration/connexion'>Se connecter</a>";
}

