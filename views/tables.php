<?php if(!defined('_DTLR')) exit('Unauthorized');

// récupérer le nom de chaque table de la base THEATRE
$tables = $this->db->listTables();

?>

<h1>Tables THEATRE</h1>

<ul>
	<?php
	// affichage - lien vers les détails / contenu des tables
	foreach($tables as $k => $table) {
		$link = 'table/THEATRE/' . strtolower($table);
		echo "<li><h3><a href='$link'>$table</a><h3></li>";
	}
	?>
</ul>