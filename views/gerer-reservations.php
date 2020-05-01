<?php if(!defined('_DTLR')) exit('Unauthorized'); ?>

<h1>Gérer les réservations</h1>

<?php

if(isset($_GET['noSerie']) && isset($_GET['action']) && $_GET['action'] == 'supprimer') {
	echo 'ok';
}

else if(isset($_GET['noSerie']) && isset($_GET['action']) && $_GET['action'] == 'modifier') {
	echo 'ok';
}

else if(isset($_GET['action']) && $_GET['action'] == 'ajouter') {
	echo 'ajout';
}

else {
	$req = "SELECT * FROM LesTickets";
	$cursor = $this->db->execute($req);
	
	$row = oci_fetch_array($cursor, OCI_ASSOC);

	echo '<a href="?modifier&noSerie=256">Modifier</a>';

	// ...
}