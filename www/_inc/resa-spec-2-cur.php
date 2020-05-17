<?php if(!defined('_DTLR')) exit('Unauthorized');

// requetes
$reqs = [
	"SELECT count(noSerie) as noSerie, dateRep, noSpec
		FROM theatre.LesTickets
		GROUP BY dateRep, noSpec",

	"SELECT noSpec, nomS
		FROM theatre.LesSpectacles"
];

$cursor1 = $this->db->execute($reqs[0]);
$cursor2 = $this->db->execute($reqs[1]);

// on trouve un/des resultat(s)
if($cursor1 && $cursor2) {

	$row1 = oci_fetch_array($cursor1, OCI_ASSOC);
	$row2 = oci_fetch_array($cursor2, OCI_ASSOC);

	// affichage
	if($row1 && $row2) {

		echo "<table>
			<tr>
				<th>noSpec</th>
				<th>dateRep</th>
				<th>nomS</th>
				<th>nbPlacesRes</th>
			</tr>";

		do {

			$noSpec1 = $row1['NOSPEC'];
			$noSpec2 = $row2['NOSPEC'];

			if($noSpec1 == $noSpec2) {
				$dateRep 	= $row1['DATEREP'];
				$nomS 		= $row2['NOMS'];
				$noSerie 	= $row1['NOSERIE'];

				echo "<tr>
					<td>$noSpec1</td>
					<td>$dateRep</td>
					<td>$nomS</td>
					<td>$noSerie</td>
				</tr>";
			}

		} while(($row1 = oci_fetch_array($cursor1, OCI_ASSOC)));

		echo "</table><br>";

	} else {

		echo "<p class='desc'>Le résultat des requêtes est vide</p>";

	}
} else {

	echo "<p class='desc'a rien trouvé</p>";

}