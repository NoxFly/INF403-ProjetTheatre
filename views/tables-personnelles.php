<?php if(!defined('_DTLR')) exit('Unauthorized');

$login = $_SESSION['login'];

// on récupère les tables de l'utilisateur
$tables = $this->db->listTables(strtoupper($login));
?>

<h1>Tables de <?php echo $login; ?></h1>

<button class='validate'>Synchroniser avec la base THEATRE</button>

<ul>
	<?php
	// affichage - lien vers le détail / contenu de chaque table
	foreach($tables as $k => $table) {
		$link = 'table/' . strtoupper($login) . '/' . strtolower($table);
		echo "<li><h3><a href='$link'>$table</a><h3></li>";
	}
	?>
</ul>