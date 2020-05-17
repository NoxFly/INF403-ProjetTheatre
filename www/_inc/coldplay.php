<?php if(!defined('_DTLR')) exit('Unauthorized');

// requete pour réupérer les données d'un spectacle :n
$req = "SELECT to_char(dateRep,'Day, DD-Month-YYYY HH:MI') as daterep
	FROM
		theatre.LesRepresentations natural join theatre.LesSpectacles
	WHERE
		lower(nomS) = lower(:n)";

// on focus le spectacle Coldplay
$cursor = $this->db->execute($req, 'Coldplay');

// si il y a un résultat - le spectacle existe
if($cursor) {

	// affichage
	if(oci_fetch($cursor)) {
		echo '<table>
			<tr>
				<th>Dates de spectacle</th>
			</tr>';
			
			do {
				$row = oci_result($cursor, 1);
				echo "<tr>
						<td>$row</td>
					</tr>";
				
			} while(oci_fetch($cursor));
		
		echo '</table>';
	}

	else {

		echo "<p class='desc'>Pas de dates de spectacle</p>";
	
	}

}

// pas de spectacle Coldplay :(
else {
	echo "<p class='desc'>Pas de dates de spectacle</p>";
}

oci_free_statement($cursor);