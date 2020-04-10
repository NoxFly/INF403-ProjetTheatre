<?php if(!defined('_DTLR')) exit('Unauthorized');

echo '<div id="specDos-res"></div>';

if(isset($_POST['category']) && !empty($category = $_POST['category'])) {
	// searching for a given category
	$places = $this->db()->getBackrestCategoryInfos($category, $noBackrest);

	if(empty($places)) {
		echo '<p style="text-align: center; color: #444; margin-bottom: 50px;">Aucune places trouvées dans cette catégorie avec ce numéro de dossier</p>';
	} else {
		$keys = array_keys($places);

		echo '<table>
			<tr>
				<th>Spectacle</th>
				<th>Place</th>
				<th>Rang</th>
				<th>Zone</th>
			</tr>';

		foreach($places as $k => $place) {
			echo '<tr>
				<td>'.$place->nomS.'</td>
				<td>'.$place->noPlace.'</td>
				<td>'.$place->noRang.'</td>
				<td>'.$place->noZone.'</td>
			</tr>';
		}

		echo '</table>';
	}
}