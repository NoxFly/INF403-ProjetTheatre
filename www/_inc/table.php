<?php

$table = preg_replace('/((.*\/)*)?(.*)/', '$3', $this->getPage());
$content = $this->db()->getTableContent($table);

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
		echo '<td>il y a du contenu</td>';
	}
}

echo '</table>';