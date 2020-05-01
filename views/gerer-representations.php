<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Gérer les représentations</h1>

<?php

if(isset($_GET['numS']) && isset($_GET['action'])) {
	echo 'ok';
}

else {
	$req = "SELECT * FROM LesTickets";
	$cursor = $this->db->execute($req);

	// ...
}