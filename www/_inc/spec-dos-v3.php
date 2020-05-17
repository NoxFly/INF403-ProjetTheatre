<?php if(!defined('_DTLR')) exit('Unauthorized');

// formulaire
echo '<form id="spec-dos-v3">';

	$req = "SELECT DISTINCT noDossier FROM theatre.LesTickets ORDER BY noDossier";

	$res = $this->db->query($req);

	// premier <select>
	echo '<select id="select-noDossier">
		<option disabled selected>Numéro dossier</option>';

		foreach($res['data'] as $line) {
			foreach($line as $elem) {
				echo "<option value='$elem'>$elem</option>";
			}
		}

	echo '</select>';

	// deuxième étape dynamique
	echo '<article id="step-2">';

		if(isset($_POST['noDossier'])) {

			$n = $_POST['noDossier'];

			$req = "SELECT DISTINCT Z.nomC
				FROM
					theatre.LesZones Z,
					theatre.LesSieges S,
					theatre.LesTickets T
				WHERE
					S.noZone = Z.noZone AND
					T.noPlace = S.noPlace AND
					T.noDossier = $n AND
					T.noRang = S.noRang";

			$res = $this->db->query($req);

			echo '<p>Veuillez saisir une catégorie:</p>';

			foreach($res['data'] as $col) {
				foreach($col as $line) {
					echo "<label for='$line'>$line<input type='radio' name='categorie' value='$line' id='$line'></label>";
				}
			}
		}

	echo "</article>";

echo '</form>';


// résultat dynamique
echo '<div id="result">';
if(isset($_POST['categorie'])) {
	$n = $_POST['noDossier'];
	$categorie = $_POST['categorie'];

	$req = "SELECT S.noPlace, S.noRang
		FROM
			theatre.LesSieges S,
			theatre.LesTickets T,
			theatre.LesZones Z
		WHERE
			Z.noZone = S.noZone AND
			S.noPlace = T.noPlace AND
			S.noRang = T.noRang AND
			T.noDossier = $n";

	$res = $this->db->query($req);

	echo "<table>
		<tr>
			<th>noPlace</th>
			<th>noRang</th>
		</tr>";

		foreach($res['data']['NORANG'] as $k => $d) {
			echo '<tr>';

			echo "<td>".$res['data']['NOPLACE'][$k]."</td><td>$d</td>";

			echo '</tr>';
		}
		
	echo '</table>';
}
echo '</div>';