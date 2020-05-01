<?php if(!defined('_DTLR')) exit('Unauthorized');


$req = "SELECT noSerie FROM theatre.LesTickets ORDER BY noSerie";

$stid = $this->db->execute($req);


$res = oci_fetch($stid);


?>

<h1>Détail du ticket <span></span></h1>

<?php


if(!$res) {

    // il n'y a aucun résultat
    echo "<p class='desc'>Aucun ticket dans la base de données</p>";

} else {

    // on affiche le formulaire de sélection
    echo "
        <form action='DetailsTicket_action.php' method='post'>
            <label for='sel_noSerie' style='width: 200px; margin-bottom: 10px'>Sélectionnez un ticket :</label><br>
			<select id='sel_noSerie' name='noSerie'>
				<option disabled selected>Numéro ticket</option>
    ";

        // création des options
        do {

            $noSerie = oci_result($stid, 1);
            echo "<option value='$noSerie'>$noSerie</option>";

        } while($res = oci_fetch($stid));

    echo "
            </select>
            <br/><br/>
        </form>
    ";

}


// on libère le curseur
oci_free_statement($stid);

echo '<div id="result">';
	if(isset($_POST['noSerie'])) {

		$req = "SELECT noSpec, dateRep, noPlace, noRang, dateEmission, noDossier
			FROM
				theatre.LesTickets
			WHERE
				noSerie = :n";
			
		$cursor = $this->db->execute($req, $_POST['noSerie']);

		if($cursor) {

			$res = oci_fetch($cursor);

			if(!$res) {
				echo "<p class='desc'>Ticket inconnu</p>";
			} else {

				echo "<table>
					<tr>
						<th>noSpec</th>
						<th>dateRep</th>
						<th>noPlace</th>
						<th>noRang</th>
						<th>dateEmission</th>
						<th>noDossier</th>
					</tr>";

				do {
					$noSpec 		= oci_result($cursor, 1);
					$dateRep 		= oci_result($cursor, 2);
					$noPlace 		= oci_result($cursor, 3);
					$noRang 		= oci_result($cursor, 4);
					$dateEmission 	= oci_result($cursor, 5);
					$noDossier 		= oci_result($cursor, 6);

					echo "<tr>
						<td>$noSpec</td>
						<td>$dateRep</td>
						<td>$noPlace</td>
						<td>$noRang</td>
						<td>$dateEmission</td>
						<td>$noDossier</td>
					</tr>";
				} while(oci_fetch($cursor));

				echo "</table>";

			}
		}

		oci_free_statement($cursor);
	}
echo "</div>";