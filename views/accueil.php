<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Projet Théâtre</h1>

<?php

if(!$this->isConnected()) {
	echo "<a class='btn home-ctn' href='administration/connexion'>Se connecter</a>";
}

