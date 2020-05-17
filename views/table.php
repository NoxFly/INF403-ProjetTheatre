<?php if(!defined('_DTLR')) exit('Unauthorized');

// on récupère le nom de la table demandée
$owner = preg_replace('/table\/(\w+)\/\w+/', '$1', $this->getPage());
$table = preg_replace('/table\/\w+\/(\w+)/', '$1', $this->getPage());

// on récupère les tables existantes
$tables = $this->db->listTables($owner);


echo "<h2>table</h2><h1 style='margin-top: 0;'>$table</h1>";

// si la table demandée n'existe pas
if(!in_array(strtoupper($table), $tables)) {
	echo "<p class='desc'>Cette table n'existe pas</p>";
}


// la table demandée existe
else {

	// on récupère son contenu
	$content = $this->db->getTableContent($owner, $table);

	// affichage
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