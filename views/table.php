<?php if(!defined('_DTLR')) exit('Unauthorized');

// get the table name
$table = preg_replace('/table\/(.+)/', '$1', $this->getPage());

$tables = $this->db()->listTables();

echo "<h2>table</h2><h1 style='margin-top: 0;'>$table</h1>";

// the asked table does not exist
if(!in_array($table, array_keys($tables))) {
	echo "<p style='text-align: center; color: #444;'>Cette table n'existe pas</p>";
}


// the asked table exists
else {

	// RECOVERY
	$content = $this->db()->getTableContent($table);

	// TABLE CONTENT
	echo '<table>
		<tr>';

		foreach(array_keys($content['data']) as $k) {
			echo "<th>$k</th>";
		}

	echo '</tr>';

		if($content['number_rows'] == 0) {
			$size = count(array_keys($content['data']));
			echo "<td colspan='$size' style='text-align: center; color: #222;'>Aucun contenu</td>";
		} else {

			for($i=0; $i < $content['number_rows']; $i++) {
				echo '<tr>';
				foreach(array_keys($content['data']) as $k) {
					echo '<td>'.$content['data'][$k][$i].'</td>';
				}
				echo '</tr>';
			}
		}

	echo '</table>';
}