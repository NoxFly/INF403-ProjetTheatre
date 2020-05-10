<?php if(!defined('_DTLR')) exit('Unauthorized');

$login = $_SESSION['login'];

$tables = $this->db->listTables(strtoupper($login));
?>

<h1>Tables de <?php echo $login; ?></h1>

<ul>
	<?php
	foreach($tables as $k => $table) {
		$link = 'table/' . strtoupper($login) . '/' . strtolower($table);
		echo "<li><h3><a href='$link'>$table</a><h3></li>";
	}
	?>
</ul>