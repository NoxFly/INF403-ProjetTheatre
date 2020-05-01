<?php if(!defined('_DTLR')) exit('Unauthorized');

$tables = $this->db->listTables();

?>

<h1>Tables</h1>

<ul>
	<?php
	foreach($tables as $k => $table) {
		$link = 'table/THEATRE/' . strtolower($table);
		echo "<li><h3><a href='$link'>$table</a><h3></li>";
	}
	?>
</ul>