<?php if(!defined('_DTLR')) exit('Unauthorized');	

echo '<div id="specDos-res"></div>';

if(isset($_POST['category']) && !empty($category = $_POST['category'])) {
	// on cherche pour une catégorie donnée
	$req = "SELECT noPlace, noRang, noZone, nomS
		FROM
			theatre.LesSieges natural join
			theatre.LesZones natural join
			theatre.LesTickets natural join
			theatre.LesSpectacles
		WHERE
			lower(nomC) = lower(:n) AND
			noDossier = $noBackrest
		ORDER BY
			noPlace";


	$cursor = $this->db->execute($req, $category);	

	// résultat trouvé
	if($cursor) {
		$row = oci_fetch($cursor);

		// affichage
		if($row) {

			echo '<table>
				<tr>
					<th>Spectacle</th>
					<th>Place</th>
					<th>Rang</th>
					<th>Zone</th>
				</tr>';

			do {

				$noPlace = oci_result($cursor, 1);
				$noRang  = oci_result($cursor, 2);
				$noZone  = oci_result($cursor, 3);
				$nomS 	 = oci_result($cursor, 4);

				echo '<tr>
					<td>'.$nomS.'</td>
					<td>'.$noPlace.'</td>
					<td>'.$noRang.'</td>
					<td>'.$noZone.'</td>
				</tr>';

			} while(oci_fetch($cursor));

			echo '</table>';

		} else {
			echo '<p class="desc">Aucunes places trouvées dans cette catégorie avec ce numéro de dossier</p>';
		}
	} else {
		echo '<p class="desc">Aucunes places trouvées dans cette catégorie avec ce numéro de dossier</p>';
	}

	oci_free_statement($cursor);
}